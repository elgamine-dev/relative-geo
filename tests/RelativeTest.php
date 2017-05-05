<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

use Elgamine\RelativeGeo\Relative;
use Elgamine\RelativeGeo\MapImage;

class RelativeTest extends TestCase {

    public $coord = [["45.044629", "-0.327043"],["42.236522", "4.867612"]];
    /** 
    * @test 
    * @expectedException Exception
    */
    public function create_map_image () {
        $this->expectException(new MapImage());
    }

    /** @test */
    public function create_map_image_wit_coordinates () {
        $img = new MapImage([ "coordinates"=>$this->coord ]);
        $this->assertNotEmpty($img->coordinates);
    }

    /** @test */
    public function create_map_image_without_size () {
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>320, "height"=>320 ]);
        $this->assertNotEmpty($img->width);
        $this->assertNotEmpty($img->height);
        $this->assertFalse($img->relative);
    }

    /** @test */
    public function create_map_image_with_padding () {
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>320, "height"=>320, "padding"=>[20,20,20,20] ]);
        $this->assertNotEmpty($img->padding);
    }

    /** @test */
    public function add_point_top_left_relative() {
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>320, "height"=>320 ]);
        $position = $img->addPoint($this->coord[0][0], $this->coord[0][1]);
        $this->assertEquals($position['x'], 0);
        $this->assertEquals($position['y'], 0);
    }

    /** @test */
    public function add_point_bottom_right_relative(){
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>320, "height"=>320 ]);
        $position = $img->addPoint($this->coord[1][0], $this->coord[1][1]);
        $this->assertEquals($position['x'], 320);
        $this->assertEquals($position['y'], 320);
    }


    /** @test */
    public function add_point_top_left_relative_padded() {
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>320, "height"=>320, "padding"=>[20,20,20,20] ]);
        $position = $img->addPoint($this->coord[0][0], $this->coord[0][1]);
        $this->assertEquals($position['x'], 20);
        $this->assertEquals($position['y'], 20);
    }

    /** @test */
    public function add_point_bottom_right_relative_padded(){
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>100, "height"=>100, "padding"=>[5,5,5,5] ]);
        $position = $img->addPoint($this->coord[1][0], $this->coord[1][1]);
        $this->assertEquals($position['x'], 95);
        $this->assertEquals($position['y'], 95);
    }

    /** @test */
    public function add_point_inbound () {
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>320, "height"=>320, "padding"=>[20,20,20,20] ]);
        $position = $img->addPoint("43.044629", "2.327043");
        $this->assertNotEmpty($position['x']);
        $this->assertNotEmpty($position['y']);
    }

    /** 
    * @test 
    * @expectedException Exception
    */
    public function add_point_outbound () {
        $img = new MapImage([ "coordinates"=>$this->coord, "width"=>320, "height"=>320, "padding"=>[20,20,20,20] ]);
        $this->expectException($img->addPoint("43.044629", "8.327043"));
        
    }

    /** @test */
    public function calc_percentage_simple() {
        $img = new MapImage([ "coordinates"=>$this->coord ]);
        $this->assertEquals($img->calcPercentage(5, 0, 10), 0.5);
        $this->assertEquals($img->calcPercentage(1, 1, 10), 0);
        $this->assertEquals($img->calcPercentage(5, 10, 0), 0.5);
        
    }

}