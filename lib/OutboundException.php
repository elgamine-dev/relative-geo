<?php

namespace Elgamine\RelativeGeo;

class OutboundException extends \Exception {

    public function __construct($message = null, $code = 0, Exception $previous = null) {

        $message = "Out of bounds $message";

        parent::__construct($message, $code, $previous);
    }
}