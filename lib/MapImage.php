<?php
namespace Elgamine\RelativeGeo;

class MapImage {

    public $coordinates;
    public $padding; // css-like : top right bottom left
    public $width;
    public $height;
    public $relative = true;
    protected $points = [];
    private $params;


    public function __construct ($params = []) {
        $this->params = $params;
        if (!isset($params['padding'])) {
            $params['padding'] = [0,0,0,0];
        }
        
        if (!isset($params['coordinates']) 
            || empty($params['coordinates']) 
            || !is_array($params['coordinates'])) {
            throw new MissingParamsException('Map coordinates are missing');
        }
        
        $this->padding = $params['padding'];
        $this->coordinates = $params['coordinates'];
        
        if (isset($params['width'], $params['height'])) {
            $this->width = $params['width'];
            $this->height = $params['height'];
            $this->relative = false;
        }
    }

    public function getPoint (Point $point) {
        $lat = $point->lat;
        $long = $point->long;
        if (!$this->inBound($lat, $long)) {
            throw new OutboundException();
        }
        $pointRelative['x'] = $this->calcPercentage($lat, $this->coordinates[0][0], $this->coordinates[1][0]);
        $pointRelative['y'] = $this->calcPercentage($long, $this->coordinates[0][1], $this->coordinates[1][1]);

        if ($this->height) {
            $pointRelative['x'] = $pointRelative['x'] * ($this->width - ($this->padding[1] + $this->padding[3])) + $this->padding[1];
            $pointRelative['y'] = $pointRelative['y'] * ($this->width - ($this->padding[0] + $this->padding[2])) + $this->padding[0];
        }

        return $pointRelative;
    }

    public function inBound ($lat, $long) {
        $coordinates = $this->coordinates;
        $min_x = min(floatval($coordinates[0][0]), floatval($coordinates[1][0]));
        $max_x = max(floatval($coordinates[0][0]), floatval($coordinates[1][0]));
        $min_y = min(floatval($coordinates[0][1]), floatval($coordinates[1][1]));
        $max_y = max(floatval($coordinates[0][1]), floatval($coordinates[1][1]));
        
        if (floatval($lat) < $min_x || floatval($lat) > $max_x) {
            throw new OutboundException('Latitude is not inbound, point : '. join(',', [$lat, $long]). '; map : '. $this);
        }
        if (floatval($long) < $min_y|| floatval($long) > $max_y) {
            throw new OutboundException('Longitude is not inbound, point : '. join(',', [$lat, $long]). '; map : '. $this);
        }
        return true;
    }

    public function calcPercentage ($point, $lowerBound, $higherBound) {
        $reverse = false;
        $point = floatval($point);
        $min = min(floatval($lowerBound), floatval($higherBound));
        $max = max(floatval($lowerBound), floatval($higherBound));
        if ($min === floatval($higherBound)) {
            $reverse = true;
        }

        $percentage = intval(($point - $min) / ($max - $min) * 100) / 100;
        if ($reverse) {
            return 1 - $percentage;
        }
        return $percentage;

    }

    public function addAddress (GeoService $geo, $address) {
        $coord = $address->resolve($geo);
        $coord->setPosition($this->getPoint($coord));
        $this->points[] = $coord;
    }

    public function listPoints () {
        return $this->points;
    }

    public function __toString() {
        return json_encode($this->params);
    }

}