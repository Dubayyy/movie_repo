<?php

namespace App\Controllers;

use App\Libraries\TmdbServices;

class Api extends BaseController
{
    protected $tmdb;
    
    public function __construct()
    {
        $this->tmdb = new TmdbServices();
    }
    
    public function search()
    {
        $query = $this->request->getGet('q');
        
        if (empty($query)) {
            return $this->response->setJSON([
                'results' => []
            ]);
        }
        
        $results = $this->tmdb->searchMovies($query, 1);
        
        return $this->response->setJSON([
            'results' => $results['results'] ?? []
        ]);
    }


    public function addToWatchlist()
{
    // Check if user is logged in
    if (!session()->get('isLoggedIn')) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'You must be logged in to add movies to your watchlist'
        ])->setStatusCode(401);
    }
    
    $movieId = $this->request->getPost('movie_id');
    
    if (!$movieId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Movie ID is required'
        ])->setStatusCode(400);
    }
    
    $userId = session()->get('id');
    $movieModel = new \App\Models\MovieModel();
    $watchlistModel = new \App\Models\WatchlistModel();
    
    // Check if the movie exists in our database
    $movie = $movieModel->where('id', $movieId)->first();
    
    if (!$movie) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Movie not found'
        ])->setStatusCode(404);
    }
    
    // Check if movie is already in watchlist
    $existingItem = $watchlistModel
        ->where('user_id', $userId)
        ->where('movie_id', $movieId)
        ->first();
    
    if ($existingItem) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Movie is already in your watchlist'
        ]);
    }
    
    // Add to watchlist
    $watchlistModel->insert([
        'user_id' => $userId,
        'movie_id' => $movieId
    ]);
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Movie added to your watchlist'
    ]);
}

public function removeFromWatchlist()
{
    // Check if user is logged in
    if (!session()->get('isLoggedIn')) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'You must be logged in to remove movies from your watchlist'
        ])->setStatusCode(401);
    }
    
    $movieId = $this->request->getPost('movie_id');
    
    if (!$movieId) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Movie ID is required'
        ])->setStatusCode(400);
    }
    
    $userId = session()->get('id');
    $watchlistModel = new \App\Models\WatchlistModel();
    
    // Remove from watchlist
    $watchlistModel
        ->where('user_id', $userId)
        ->where('movie_id', $movieId)
        ->delete();
    
    return $this->response->setJSON([
        'success' => true,
        'message' => 'Movie removed from your watchlist'
    ]);
}
}