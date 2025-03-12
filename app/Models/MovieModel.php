<?php

namespace App\Models;

use CodeIgniter\Model;

class MovieModel extends Model
{
    protected $table = 'movies'; // Your table name
    protected $primaryKey = 'id'; // Primary key
    protected $allowedFields = ['title', 'genre', 'release_year', 'rating', 'poster']; // Allowed fields
}
