<?php

namespace App\Validation\Rules;

use App\Models\User;
use Respect\Validation\Rules\AbstractRule;

/**
 * Custom rule for for email availability when submitting
 * parent and child sign up forms.
 * 
 * @author Michael Navarro
 */
class EmailAvailable extends AbstractRule {

    /**
     * Determines whether User with email already exists in database.
     * 
     * @param type $input
     * @return User
     */
    public function validate($input) {
        return User::where('email', $input)->count() === 0;
    }

}
