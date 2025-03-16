<?php

namespace App\Models;

use CodeIgniter\Model;

class MovieModel extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'tmdb_id', 'title', 'poster_path', 'backdrop_path', 
        'overview', 'release_date', 'popularity', 
        'vote_average', 'vote_count'
    ];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // I don't have this field in table yet
}