<?php
require __DIR__ . '/../vendor/autoload.php';

use Elgamine\RelativeGeo\MapImage;
use Elgamine\RelativeGeo\Address;
use Elgamine\RelativeGeo\GeoService;
use Elgamine\RelativeGeo\Point;


$img = new MapImage([ 
    "coordinates"=>[["-0.327043","45.044629"],["4.867612", "42.236522"]],
    "width"=>320, "height"=>320, 
    "padding"=>[20,20,20,20]
]);
$geo = new GeoService();
try {

    $img->addAddress($geo, new Address("Tarbes"));
    $img->addAddress($geo, new Address("Toulouse"));

} catch (Exception $e) {
    var_dump($e->getMessage());
}


$points = $img->listPoints();

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <pre><?php print_r($points) ?></pre>
</body>
</html>