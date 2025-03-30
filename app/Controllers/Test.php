<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        echo "Test controller is working!";
    }
    
    public function register_form()
    {
        echo '<!DOCTYPE html>
        <html>
        <head>
            <title>Test Registration</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <div class="card">
                    <div class="card-header">Test Registration</div>
                    <div class="card-body">
                        <form action="' . base_url('test/process_register') . '" method="post">
                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" class="form-control" name="username">
                            </div>
                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email">
                            </div>
                            <div class="mb-3">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </body>
        </html>';
    }
    
    public function process_register()
    {
        echo "Received form data:<br>";
        echo "<pre>";
        print_r($this->request->getPost());
        echo "</pre>";
        
        echo "Request method: " . $this->request->getMethod() . "<br>";
        echo "Is POST according to getMethod(): " . ($this->request->getMethod() === 'post' ? 'Yes' : 'No') . "<br>";
        
        // Try to create user regardless of method detection
        $username = $this->request->getPost('username');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        
        if (empty($username) || empty($email) || empty($password)) {
            echo "Error: Missing required fields.";
            return;
        }
        
        echo "Attempting to create user with:<br>";
        echo "Username: $username<br>";
        echo "Email: $email<br>";
        
        try {
            $userModel = new \App\Models\UserModel();
            $result = $userModel->insert([
                'username' => $username,
                'email' => $email,
                'password' => $password
            ]);
            
            echo "<br>Result: " . ($result ? "Success" : "Failed");
            
            if ($result) {
                echo "<br>User created with ID: " . $userModel->getInsertID();
            } else {
                echo "<br>Errors: ";
                print_r($userModel->errors());
            }
        } catch (\Exception $e) {
            echo "<br>Exception: " . $e->getMessage();
        }
    }
}