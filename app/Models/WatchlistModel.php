<?php

namespace App\Models;

use CodeIgniter\Model;

class WatchlistModel extends Model
{
    protected $table = 'watchlists';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['user_id', 'movie_id'];
    
    protected $useTimestamps = true;
    protected $createdField = 'added_at';
    protected $updatedField = ''; // We don't have this field in our table
}