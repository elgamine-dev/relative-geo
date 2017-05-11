<?php

namespace Elgamine\RelativeGeo;

class MissingParamsException extends \Exception {

    public function __construct($message = null, $code = 0, Exception $previous = null) {
        $message = "Can't instantiate class correctly, missing parameter $message";
        parent::__construct($message, $code, $previous);
    }
}