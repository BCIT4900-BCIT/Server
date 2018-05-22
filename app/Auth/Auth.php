<?php

namespace App\Auth;

use App\Models\User;

/**
 * Contains functions relating to the authentication
 * of users and the setting and unsetting of a user session
 * variable.
 * 
 * @author  Michael Navaro
 */
class Auth {

    /**
     * Returns a User model created from the email stored in
     * the user session variable.
     * 
     * @return User
     */
    public function user() {
        $user = User::where('email', $_SESSION['user'] ?? '')->first();
        return $user;
    }

    /**
     * Returns true if user session variable is set.
     * 
     * @return boolean
     */
    public function check() {
        return isset($_SESSION['user']);
    }

    /**
     * Attempts to authenticate user by searching
     * in the database for a matching user/password combo.
     * In then checks if the user has a null groupid, signifying
     * that it is a parent. If both conditions are met, the email
     * is set as the user session variable and returns true, otherwise
     * it returns false.
     * 
     * @param type $email
     * @param type $password
     * @return boolean
     */
    public function attempt($email, $password) {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (($password == $user->password) && is_null($user->groupid)) {
            $_SESSION['user'] = $user->email;
            return true;
        }

        return false;
    }

    /**
     * Unsets the user session variable.
     */
    public function signout() {
        unset($_SESSION['user']);
    }

}
