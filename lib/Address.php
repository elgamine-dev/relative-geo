<?php
namespace Elgamine\RelativeGeo;

class Address {

    public $address;

    public function __construct ($address) {
        $this->address = $address;
    }

    public function resolve (GeoService $geo) {
        return $geo->get($this->address);
    }

}