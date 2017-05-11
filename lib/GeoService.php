<?php

namespace Elgamine\RelativeGeo;

class GeoService {

    private $baseURI = "http://api-adresse.data.gouv.fr/search/";
    private $query = "q";
    private $limit = 1;

    public function get($address){
        $params = join("", ["limit=" , $this->limit, "&",  $this->query, "=", $address]);
        $url = join("", [$this->baseURI, "?", $params]);
        try {
            $res = json_decode(file_get_contents($url), true);
        } catch (Exception $e) {
            throw new Exception("Can't resolve request");
        }

        return new Point(["address"=> $address, "coordinates" => $res['features'][0]['geometry']['coordinates']]);
    }

}