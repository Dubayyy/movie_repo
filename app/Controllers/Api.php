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

     
    public function quickView()
{
    $id = $this->request->getGet('id');
    
    if (!$id) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Movie ID is required'
        ]);
    }
    
    $tmdb = new \App\Libraries\TmdbServices();
    $movie = $tmdb->getMovie($id);
    
    if (!$movie) {
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Movie not found'
        ]);
    }
    
    //HTML for the modal display
    $html = '
    <div class="position-relative" style="background-color: #121212; color: white;">
        <button type="button" class="btn-close position-absolute end-0 top-0 m-3 bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
        ' . ($movie['backdrop_path'] ? '
        <div style="height: 200px; background-image: linear-gradient(rgba(0, 0, 0, 0.7), rgba(18, 18, 18, 0.9)), url(\'https://image.tmdb.org/t/p/w780' . $movie['backdrop_path'] . '\'); background-size: cover; background-position: center;"></div>
        ' : '') . '
        
        <div class="container p-4">
            <div class="row">
                <div class="col-md-4 text-center mb-3">
                    ' . ($movie['poster_path'] ? '
                    <img src="https://image.tmdb.org/t/p/w342' . $movie['poster_path'] . '" alt="' . $movie['title'] . '" class="img-fluid rounded mb-3" style="max-height: 300px;">
                    ' : '') . '
                    <a href="' . base_url('movies/view/' . $movie['id']) . '" class="btn btn-primary w-100">Full Details</a>
                </div>
                <div class="col-md-8">
                    <h3 class="text-white">' . $movie['title'] . ' <small class="text-light">(' . (isset($movie['release_date']) ? substr($movie['release_date'], 0, 4) : 'N/A') . ')</small></h3>
                    
                    <div class="mb-3">
                        <span class="badge bg-primary p-2"><i class="fas fa-star me-1"></i> ' . number_format($movie['vote_average'], 1) . '</span>
                        ' . (isset($movie['runtime']) ? '<span class="ms-2 text-light">' . floor($movie['runtime'] / 60) . 'h ' . ($movie['runtime'] % 60) . 'm</span>' : '') . '
                    </div>
                    
                    <p class="text-light">' . (strlen($movie['overview']) > 300 ? substr($movie['overview'], 0, 300) . '...' : $movie['overview']) . '</p>
                    
                    <div class="mb-3">
                        <h5 class="text-white">Genres</h5>
                        <div>';
    
    if (isset($movie['genres']) && !empty($movie['genres'])) {
        foreach ($movie['genres'] as $genre) {
            $html .= '<span class="badge badge-custom me-1 mb-1">' . $genre['name'] . '</span>';
        }
    }
    
    $html .= '
                        </div>
                    </div>';
    
    // Show cast if available
    if (isset($movie['credits']['cast']) && !empty($movie['credits']['cast'])) {
        $html .= '
                    <div>
                        <h5 class="text-white">Cast</h5>
                        <div class="row">';
        
        $castCount = 0;
        foreach ($movie['credits']['cast'] as $cast) {
            if ($castCount >= 4) break;
            
            $html .= '
                            <div class="col-6 mb-2">
                                <div class="d-flex align-items-center">
                                    <div class="me-2">';
            
            if (isset($cast['profile_path']) && $cast['profile_path']) {
                $html .= '<img src="https://image.tmdb.org/t/p/w45' . $cast['profile_path'] . '" alt="' . $cast['name'] . '" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover;">';
            } else {
                $html .= '<div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" style="width: 30px; height: 30px;"><i class="fas fa-user text-white small"></i></div>';
            }
            
            $html .= '
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-white">' . $cast['name'] . '</div>
                                        <div class="small text-light">' . $cast['character'] . '</div>
                                    </div>
                                </div>
                            </div>';
            
            $castCount++;
        }
        
        $html .= '
                        </div>
                    </div>';
    }
    
    $html .= '
                </div>
            </div>
        </div>
    </div>';
    
    return $this->response->setJSON([
        'success' => true,
        'html' => $html
    ]);
}






}