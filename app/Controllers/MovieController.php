<?php

namespace App\Controllers;

use App\Models\MovieModel;
use CodeIgniter\Controller;

class MovieController extends Controller
{
    public function index()
    {
        $movieModel = new MovieModel();
        $data['movies'] = $movieModel->findAll(); // Get all movies from DB
        return view('movies/index', $data); // Load the view
    }

    public function create()
    {
        return view('movies/create'); // Load form to add a movie
    }

    public function store()
    {
        $movieModel = new MovieModel();

        $movieModel->save([
            'title' => $this->request->getPost('title'),
            'genre' => $this->request->getPost('genre'),
            'release_year' => $this->request->getPost('release_year'),
            'rating' => $this->request->getPost('rating'),
            'poster' => $this->request->getPost('poster'),
        ]);

        return redirect()->to('/movies');
    }

    public function edit($id)
    {
        $movieModel = new MovieModel();
        $data['movie'] = $movieModel->find($id); // Find movie by ID
        return view('movies/edit', $data);
    }

    public function update($id)
    {
        $movieModel = new MovieModel();

        $movieModel->update($id, [
            'title' => $this->request->getPost('title'),
            'genre' => $this->request->getPost('genre'),
            'release_year' => $this->request->getPost('release_year'),
            'rating' => $this->request->getPost('rating'),
            'poster' => $this->request->getPost('poster'),
        ]);

        return redirect()->to('/movies');
    }

    public function delete($id)
    {
        $movieModel = new MovieModel();
        $movieModel->delete($id); // Delete movie by ID
        return redirect()->to('/movies');
    }
}
