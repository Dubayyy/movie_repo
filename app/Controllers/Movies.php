<?php

namespace App\Controllers;

use App\Models\MovieModel;

class Movies extends BaseController
{
    public function index()
    {
        return view('movies/index');
    }
    
    public function view($id = null)
    {
        return view('movies/view');
    }
}