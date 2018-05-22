<?php

namespace App\Validation;

use Respect\Validation\Validator as Respect;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Contains functions for validation.
 * 
 * @author Michael Navarro
 */
class Validator {

    /**
     * Receives request and list of rules. Check if rules or fail.
     * If fail, add rule to errors global session variable.
     * 
     * @param type $request
     * @param array $rules
     * @return $this
     */
    public function validate($request, array $rules) {
        foreach ($rules as $field => $rule) {
            try {

                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION['errors'] = $this->errors;

        return $this;
    }

    /**
     * Checks if session global errors variable is empty.
     * 
     * @return boolean
     */
    public function failed() {
        return !empty($this->errors);
    }

}
