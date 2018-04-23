<?php

namespace Green\Exceptions;
use Exception;

class ValidationException extends Exception
{
    public $errors;

    // Redefine the exception so message isn't optional
    public function __construct($message="Validation error", $code = 422, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
