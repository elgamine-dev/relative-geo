<?php
namespace Elgamine\RelativeGeo;

class MapImage {

    public $coordinates;
    public $padding; // css-like : top right bottom left
    public $width;
    public $height;
    public $relative = true;


    public function __construct ($params = []) {
        if (!isset($params['padding'])) {
            $params['padding'] = [0,0,0,0];
        }
        
        if (!isset($params['coordinates']) 
            || empty($params['coordinates']) 
            || !is_array($params['coordinates'])) {
            throw new \Exception('Map coordinates are missing');
        }
        
        $this->padding = $params['padding'];
        $this->coordinates = $params['coordinates'];
        
        if (isset($params['width'], $params['height'])) {
            $this->width = $params['width'];
            $this->height = $params['height'];
            $this->relative = false;
        }
    }

    public function addPoint ($lat, $long) {
        if (!$this->inBound($lat, $long)) {
            throw new \Exception('Point is not inbound');
        }
        $point['x'] = $this->calcPercentage($lat, $this->coordinates[0][0], $this->coordinates[1][0]);
        $point['y'] = $this->calcPercentage($long, $this->coordinates[0][1], $this->coordinates[1][1]);

        if ($this->height) {
            $point['x'] = $point['x'] * ($this->width - ($this->padding[1] + $this->padding[3])) + $this->padding[1];
            $point['y'] = $point['y'] * ($this->width - ($this->padding[0] + $this->padding[2])) + $this->padding[0];
        }

        return $point;
    }

    public function inBound ($lat, $long) {
        $coordinates = $this->coordinates;
        $min_x = min(floatval($coordinates[0][0]), floatval($coordinates[1][0]));
        $max_x = max(floatval($coordinates[0][0]), floatval($coordinates[1][0]));
        $min_y = min(floatval($coordinates[0][1]), floatval($coordinates[1][1]));
        $max_y = max(floatval($coordinates[0][1]), floatval($coordinates[1][1]));
        
        if(floatval($lat) < $min_x || floatval($lat) > $max_x) {
            throw new \Exception('Latitude is not inbound');
        }
        if(floatval($long) < $min_y|| floatval($long) > $max_y) {
            throw new \Exception('Longitude is not inbound');
        }
        return true;
    }

    public function calcPercentage($point, $lowerBound, $higherBound) {
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

}