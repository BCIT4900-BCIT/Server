<?php

namespace App\Auth;

use App\Models\User;

class Auth
{
    public function user()
    {
        return User::where('email', $_SESSION['user'] ?? '')->first();
    }
    
    /*
    public function check()
    {
        return isset($_SESSION['user']);
    }
    */
    
    public function check()
    {
        $user = User::where('email', $_SESSION['user'] ?? '')->first();
        if ($user->groupid != null)
        {
           return isset($_SESSION['user']); 
        }
        return false;
    }
    
    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return false;
        }
        
        if(password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->email;
            return true;
        }
        
        return false;
    }
    
    public function signout()
    {
        unset($_SESSION['user']);
    }
}