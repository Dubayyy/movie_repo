<?php

namespace App\Controllers;

use App\Models\MovieModel;
use App\Models\ReviewModel;

class Reviews extends BaseController
{
    protected $movieModel;
    protected $reviewModel;
    
    public function __construct()
    {
        $this->movieModel = new MovieModel();
        $this->reviewModel = new ReviewModel();
    }
    
    public function create($movieId)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login')->with('error', 'You must be logged in to write a review');
        }
        
        // Validate form input
        $rules = [
            'rating' => 'required|numeric|greater_than[0]|less_than_equal_to[5]',
            'review_text' => 'required|min_length[10]'
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', 'Please check your review. Rating must be between 1-5 and review must be at least 10 characters.');
        }
        
        $userId = session()->get('id');
        
        // Check if user has already reviewed this movie
        $existingReview = $this->reviewModel
            ->where('user_id', $userId)
            ->where('movie_id', $movieId)
            ->first();
        
        if ($existingReview) {
            // Update existing review
            $this->reviewModel->update($existingReview['id'], [
                'rating' => $this->request->getPost('rating'),
                'review_text' => $this->request->getPost('review_text')
            ]);
            
            return redirect()->back()->with('success', 'Your review has been updated');
        } else {
            // Create new review
            $this->reviewModel->insert([
                'user_id' => $userId,
                'movie_id' => $movieId,
                'rating' => $this->request->getPost('rating'),
                'review_text' => $this->request->getPost('review_text')
            ]);
            
            return redirect()->back()->with('success', 'Your review has been posted');
        }
    }
    
    public function delete($id)
    {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('auth/login');
        }
        
        $userId = session()->get('id');
        $review = $this->reviewModel->find($id);
        
        // Check if review exists and belongs to user
        if (!$review || $review['user_id'] != $userId) {
            return redirect()->back()->with('error', 'You cannot delete this review');
        }
        
        // Delete the review
        $this->reviewModel->delete($id);
        
        return redirect()->back()->with('success', 'Review deleted successfully');
    }
}