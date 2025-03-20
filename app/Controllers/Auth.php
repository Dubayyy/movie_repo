<?php
namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // Check if already logged in
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        // Handle form submission
        if ($this->request->getMethod() === 'post') {
            // Get form data
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            
            // Validate inputs
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]'
            ];
            
            if (!$this->validate($rules)) {
                return view('auth/login', [
                    'validation' => $this->validator
                ]);
            }
            
            // Check user credentials
            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();
            
            if ($user && password_verify($password, $user['password'])) {
                // Credentials are valid, set session
                $session = session();
                $session->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'isLoggedIn' => true
                ]);
                
                return redirect()->to('/');
            } else {
                // Invalid credentials
                return view('auth/login', [
                    'error' => 'Invalid email or password'
                ]);
            }
        }
        
        // Display login form
        return view('auth/login');
    }
    
    public function register()
    {
        // Check if already logged in
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        // Handle form submission
        if ($this->request->getMethod() === 'post') {
            // Get form data
            $username = $this->request->getPost('username');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $confirmPassword = $this->request->getPost('confirm_password');
            
            // Validate inputs
            $rules = [
                'username' => 'required|min_length[3]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]'
            ];
            
            if (!$this->validate($rules)) {
                return view('auth/register', [
                    'validation' => $this->validator
                ]);
            }
            
            // Create user
            $userModel = new UserModel();
            $userModel->insert([
                'username' => $username,
                'email' => $email,
                'password' => $password  // Model will hash this
            ]);
            
            // Set success message and redirect to login
            session()->setFlashdata('success', 'Registration successful. Please login.');
            return redirect()->to('auth/login');
        }
        
        // Display registration form
        return view('auth/register');
    }
    
    public function logout()
    {
        // Clear session and redirect to homepage
        session()->destroy();
        return redirect()->to('/');
    }
}