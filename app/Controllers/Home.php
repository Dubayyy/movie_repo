<?php
namespace App\Controllers;

use App\Libraries\TmdbServices;

class Home extends BaseController 
{
    protected $tmdb;
    
    public function __construct()
    {
        $this->tmdb = new TmdbServices();
    }
    
    public function index()
    {
        // Get popular movies for the homepage
        $data['featured_movies'] = $this->tmdb->getPopular(1);
        $data['title'] = 'CineVerse - Your Ultimate Movie Experience';
        
        // Pass a closure to get poster URL
        $data['getPosterUrl'] = function($poster_path) {
            return $this->tmdb->getPosterUrl($poster_path);
        };
        
        return view('home/index', $data);
    }
}