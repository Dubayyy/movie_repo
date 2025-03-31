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
    
    public function getProfile()
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login')->with('error', 'You must be logged in to view your profile');
        }
        
        $data['title'] = 'My Profile';
        
        // Get user data from session
        $data['user'] = [
            'id' => session()->get('id'),
            'username' => session()->get('username'),
            'email' => session()->get('email')
        ];
        
        return view('home/profile', $data);
    }
}