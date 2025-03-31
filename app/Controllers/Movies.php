<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Libraries\TmdbServices;

class Movies extends BaseController
{
    protected $tmdb;
    protected $movieModel;
    
    public function __construct()
    {
        $this->tmdb = new TmdbServices();
        $this->movieModel = new MovieModel();
    }
    
    public function index()
    {
        $page = $this->request->getGet('page') ?? 1;
        $data['movies'] = $this->tmdb->getPopular($page);
        $data['page'] = $page;
        $data['title'] = 'Discover Movies';
        $data['tmdb'] = $this->tmdb;
        
        return view('movies/index', $data);
    }
    
    public function view($id = null)
    {
        if (!$id) {
            return redirect()->to('/movies');
        }
        
        // Get movie details from API
        $movie = $this->tmdb->getMovie($id);
        
        if (!$movie) {
            return redirect()->to('/movies')->with('error', 'Movie not found');
        }
        
        // Check if movie exists in my database
        $dbMovie = $this->movieModel->where('tmdb_id', $id)->first();
        
        // If not, add it to my database
        if (!$dbMovie) {
            $this->movieModel->insert([
                'tmdb_id' => $movie['id'],
                'title' => $movie['title'],
                'poster_path' => $movie['poster_path'],
                'backdrop_path' => $movie['backdrop_path'],
                'overview' => $movie['overview'],
                'release_date' => $movie['release_date'] ?? null,
                'popularity' => $movie['popularity'] ?? 0,
                'vote_average' => $movie['vote_average'] ?? 0,
                'vote_count' => $movie['vote_count'] ?? 0
            ]);
            
            $dbMovie = $this->movieModel->where('tmdb_id', $id)->first();
        }
        
        // Check if movie is in user's watchlist
        $inWatchlist = false;
        if (session()->get('isLoggedIn')) {
            $watchlistModel = new \App\Models\WatchlistModel();
            $watchlistItem = $watchlistModel
                ->where('user_id', session()->get('id'))
                ->where('movie_id', $dbMovie['id'])
                ->first();
            
            $inWatchlist = $watchlistItem ? true : false;
        }
        $data['inWatchlist'] = $inWatchlist;
        
        // Get reviews for this movie
        $reviewModel = new \App\Models\ReviewModel();
        $reviews = $reviewModel->join('users', 'users.id = reviews.user_id')
            ->select('reviews.*, users.username')
            ->where('reviews.movie_id', $dbMovie['id'])
            ->orderBy('reviews.created_at', 'DESC')
            ->findAll();
            
        $data['reviews'] = $reviews;
        
        $data['movie'] = $movie;
        $data['dbMovie'] = $dbMovie;
        $data['title'] = $movie['title'] . ' - CineVerse';
        $data['tmdb'] = $this->tmdb;
        
        return view('movies/view', $data);
    }

    public function search()
{
    $query = $this->request->getGet('q');
    $page = $this->request->getGet('page') ?? 1;
    
    if (empty($query)) {
        return redirect()->to('/movies');
    }
    
    $data['movies'] = $this->tmdb->searchMovies($query, $page);
    $data['query'] = $query;
    $data['page'] = $page;
    $data['title'] = 'Search Results for: ' . $query;
    $data['tmdb'] = $this->tmdb; 
    
    return view('movies/search', $data);
}

public function ajaxSearch()
{
    $query = $this->request->getGet('q');
    
    if (!$query) {
        return $this->response->setJSON(['status' => 'error', 'message' => 'No query provided']);
    }
    
    $results = $this->tmdb->searchMovies($query, 1);
    return $this->response->setJSON($results);
}

}    