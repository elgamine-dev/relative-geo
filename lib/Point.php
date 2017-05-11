<?php
namespace Elgamine\RelativeGeo;

class Point {
    public $lat;
    public $long;
    public $address;
    public $x;
    public $y;

    public function __construct (Array $data) {
        $this->lat = $data['coordinates'][0];
        $this->long = $data['coordinates'][1];
        if (isset($data['address'])) {
            $this->address = $data['address'];
        }
    }

    public function getCoordinates(){
        return [$this->lat, $this->long];
    }

    public function setPosition($position) {
        $this->x = $position['x'];
        $this->y = $position['y'];
    }
}