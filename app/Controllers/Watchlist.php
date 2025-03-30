<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\WatchlistModel;
use App\Libraries\TmdbServices;

class Watchlist extends BaseController
{
    protected $tmdb;
    protected $movieModel;
    protected $watchlistModel;
    
    public function __construct()
    {
        $this->tmdb = new TmdbServices();
        $this->movieModel = new MovieModel();
        $this->watchlistModel = new WatchlistModel();
    }
    
    public function index()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login')->with('error', 'You must be logged in to view your watchlist');
        }
        
        $userId = session()->get('id');
        
        // Get user's watchlist
        $watchlistItems = $this->watchlistModel
            ->select('watchlists.*, movies.*')
            ->join('movies', 'movies.id = watchlists.movie_id')
            ->where('watchlists.user_id', $userId)
            ->orderBy('watchlists.added_at', 'DESC')
            ->findAll();
        
        $data['watchlistItems'] = $watchlistItems;
        $data['title'] = 'My Watchlist';
        
        return view('watchlist/index', $data);
    }
    
    public function add($movieId)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login')->with('error', 'You must be logged in to add movies to your watchlist');
        }
        
        $userId = session()->get('id');
        
        // Check if the movie exists in our database
        $movie = $this->movieModel->where('tmdb_id', $movieId)->first();
        
        // If not, fetch from API and add it
        if (!$movie) {
            $movieData = $this->tmdb->getMovie($movieId);
            
            if (!$movieData) {
                return redirect()->back()->with('error', 'Movie not found');
            }
            
            $this->movieModel->insert([
                'tmdb_id' => $movieData['id'],
                'title' => $movieData['title'],
                'poster_path' => $movieData['poster_path'],
                'backdrop_path' => $movieData['backdrop_path'],
                'overview' => $movieData['overview'],
                'release_date' => $movieData['release_date'] ?? null,
                'popularity' => $movieData['popularity'] ?? 0,
                'vote_average' => $movieData['vote_average'] ?? 0,
                'vote_count' => $movieData['vote_count'] ?? 0
            ]);
            
            $movie = $this->movieModel->where('tmdb_id', $movieId)->first();
        }
        
        // Check if movie is already in watchlist
        $existingItem = $this->watchlistModel
            ->where('user_id', $userId)
            ->where('movie_id', $movie['id'])
            ->first();
        
        if ($existingItem) {
            return redirect()->back()->with('warning', 'Movie is already in your watchlist');
        }
        
        // Add to watchlist
        $this->watchlistModel->insert([
            'user_id' => $userId,
            'movie_id' => $movie['id']
        ]);
        
        return redirect()->to('movies/view/' . $movieId)->with('success', 'Movie added to your watchlist');
    }
    
    public function remove($id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login');
        }
        
        $userId = session()->get('id');
        
        // Remove from watchlist
        $this->watchlistModel
            ->where('user_id', $userId)
            ->where('movie_id', $id)
            ->delete();
        
        return redirect()->back()->with('success', 'Movie removed from your watchlist');
    }
}