<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{


    public function login()
    {
        // Already logged in check
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];
            
            if ($this->validate($rules)) {
                $userModel = new UserModel();
                $user = $userModel->where('email', $this->request->getPost('email'))->first();
                
                if ($user && password_verify($this->request->getPost('password'), $user['password'])) {
                    session()->set([
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'email' => $user['email'],
                        'isLoggedIn' => true
                    ]);
                    
                    return redirect()->to('/');
                } else {
                    return view('auth/login', [
                        'error' => 'Invalid login credentials'
                    ]);
                }
            } else {
                return view('auth/login', [
                    'validation' => $this->validator
                ]);
            }
        }
        
        return view('auth/login');
    }
    
    public function register()
    {
        // Already logged in check
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/');
        }
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'username' => 'required|min_length[3]|is_unique[users.username]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
                
            ];
            
            if ($this->validate($rules)) {
                $userModel = new UserModel();
                
                $userModel->insert([
                    'username' => $this->request->getPost('username'),
                    'email' => $this->request->getPost('email'),
                    'password' => $this->request->getPost('password')
                ]);
                
                session()->setFlashdata('success', 'Registration successful. Please login.');
                return redirect()->to('auth/login');
            } else {
                return view('auth/register', [
                    'validation' => $this->validator
                ]);
            }
        }
        
        return view('auth/register');

    }

    public function logout()
{
    // Clear all session data
    session()->destroy();
    
    // Redirect to the home page
    return redirect()->to('/');
}
}