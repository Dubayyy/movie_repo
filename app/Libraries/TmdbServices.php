<?php

namespace App\Libraries;

class TmdbServices
{
    protected $accessToken;
    protected $baseUrl = 'https://api.themoviedb.org/3';
    protected $imageBaseUrl = 'https://image.tmdb.org/t/p/';
    
    public function __construct()
    {
        // Loads access token from .env file
        $this->accessToken = getenv('TMDB_ACCESS_TOKEN');
        
        if (!$this->accessToken) {
            // Fallback access token in case .env isn't configured
            $this->accessToken = 'eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIzNWZkYWM1MDI4NWUwMmI1YzIwZWFiOGUyYWY3MjI5NSIsIm5iZiI6MTc0MjE0ODU5MC45OTIsInN1YiI6IjY3ZDcxM2VlMTNkMGU5NmI0MjdiZjVmMyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.tQr7VqifxidZNvdlpKgYlfNMWkKE95ewNmpjx0qtA4Q';
        }
    }
    
    /**
     * Get popular movies
     */
    public function getPopular($page = 1)
    {
        $url = $this->baseUrl . '/movie/popular?page=' . $page;
        return $this->sendRequest($url);
    }
    
    /**
     * Get movie details by ID
     */
    public function getMovie($id)
    {
        $url = $this->baseUrl . '/movie/' . $id . '?append_to_response=credits,videos,similar';
        return $this->sendRequest($url);
    }
    
    /**
     * Search for movies
     */
    public function searchMovies($query, $page = 1)
    {
        $url = $this->baseUrl . '/search/movie?query=' . urlencode($query) . '&page=' . $page;
        return $this->sendRequest($url);
    }
    
    /**
     * Get now playing movies
     */
    public function getNowPlaying($page = 1)
    {
        $url = $this->baseUrl . '/movie/now_playing?page=' . $page;
        return $this->sendRequest($url);
    }
    
    /**
     * Get poster URL
     */
    public function getPosterUrl($path, $size = 'w500')
    {
        if (empty($path)) {
            return null;
        }
        
        return $this->imageBaseUrl . $size . $path;
    }
    
    /**
     * Get backdrop URL
     */
    public function getBackdropUrl($path, $size = 'w1280')
    {
        if (empty($path)) {
            return null;
        }
        
        return $this->imageBaseUrl . $size . $path;
    }
    
    /**
     * Send HTTP request to the API using the access token
     */
    protected function sendRequest($url)
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "Authorization: Bearer " . $this->accessToken,
                "Accept: application/json"
            ],
        ]);
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            return null;
        }
        
        return json_decode($response, true);
    }


   

}