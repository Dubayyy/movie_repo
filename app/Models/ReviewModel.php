<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table = 'reviews';
    protected $primaryKey = 'id';
    
    protected $allowedFields = ['user_id', 'movie_id', 'rating', 'review_text'];
    
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // We don't have this field in our table
}