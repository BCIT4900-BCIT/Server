<?php

namespace App\Auth;

use App\Models\User;

class Auth
{
    public function user()
    {
        $user = User::where('email', $_SESSION['user'] ?? '')->first();
        return $user;
    }
    
    public function check()
    {
        return isset($_SESSION['user']);
    }
    
    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return false;
        }
        
        if(password_verify($password, $user->password) && is_null($user->groupid)) {
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