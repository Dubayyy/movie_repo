<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\WatchlistModel;
use App\Models\ReviewModel;
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
        
        // Pass poster URL method
        $data['getPosterUrl'] = functsion($poster_path) {
            return $this->tmdb->getPosterUrl($poster_path);
        };
        
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
        
        // Check if movie exists in our database
        $dbMovie = $this->movieModel->where('tmdb_id', $id)->first();
        
        // If not, add it to our database
        if (!$dbMovie) {
            $this->movieModel->insert([
                'tmdb_id' => $movie['id'],
                'title' => $movie['title'],
                'poster_path' => $movie['poster_path'],
                'backdrop_path' => $movie['backdrop_path'],
                'overview' => $movie['overview'],
                'release_date' => $movie['release_date'],
                'popularity' => $movie['popularity'],
                'vote_average' => $movie['vote_average'],
                'vote_count' => $movie['vote_count']
            ]);
            
            $dbMovie = $this->movieModel->where('tmdb_id', $id)->first();
        }
        
        // Check if movie is in user's watchlist
        $data['inWatchlist'] = false;
        
        if (session()->get('isLoggedIn')) {
            $watchlistModel = new WatchlistModel();
            $userId = session()->get('id');
            
            $data['inWatchlist'] = $watchlistModel
                ->where('user_id', $userId)
                ->where('movie_id', $dbMovie['id'])
                ->countAllResults() > 0;
        }
        
        // Get reviews
        $reviewModel = new ReviewModel();
        $data['reviews'] = $reviewModel
            ->select('reviews.*, users.username')
            ->join('users', 'users.id = reviews.user_id')
            ->where('movie_id', $dbMovie['id'])
            ->orderBy('created_at', 'DESC')
            ->findAll();
        
        $data['movie'] = $movie;
        $data['dbMovie'] = $dbMovie;
        $data['title'] = $movie['title'] . ' - CineVerse';
        
        // Pass poster URL method
        $data['getPosterUrl'] = function($poster_path) {
            return $this->tmdb->getPosterUrl($poster_path);
        };

        $data['getBackdropUrl'] = function($backdrop_path) {
            return $this->tmdb->getBackdropUrl($backdrop_path);
        };
        
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
        
        // Pass poster URL method
        $data['getPosterUrl'] = function($poster_path) {
            return $this->tmdb->getPosterUrl($poster_path);
        };
        
        return view('movies/search', $data);
    }
    
    public function nowPlaying()
    {
        $page = $this->request->getGet('page') ?? 1;
        $data['movies'] = $this->tmdb->getNowPlaying($page);
        $data['page'] = $page;
        $data['title'] = 'Now Playing Movies';
        
        // Pass poster URL method
        $data['getPosterUrl'] = function($poster_path) {
            return $this->tmdb->getPosterUrl($poster_path);
        };
        
        return view('movies/now_playing', $data);
    }
}