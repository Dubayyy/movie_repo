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
                'release_date' => $movie['release_date'] ?? null,
                'popularity' => $movie['popularity'] ?? 0,
                'vote_average' => $movie['vote_average'] ?? 0,
                'vote_count' => $movie['vote_count'] ?? 0
            ]);
            
            $dbMovie = $this->movieModel->where('tmdb_id', $id)->first();
        }
        
        // For now, set inWatchlist to false (i'll implement this later)
        $data['inWatchlist'] = false;
        
        // Empty reviews for now (we'll implement this later)
        $data['reviews'] = [];
        
        $data['movie'] = $movie;
        $data['dbMovie'] = $dbMovie;
        $data['title'] = $movie['title'] . ' - CineVerse';
        $data['tmdb'] = $this->tmdb;  // Pass the entire service
        
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
    $data['tmdb'] = $this->tmdb;  // This line must be here
    
    return view('movies/search', $data);
}
}