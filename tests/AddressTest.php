<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

use Elgamine\RelativeGeo\Relative;
use Elgamine\RelativeGeo\MapImage;
use Elgamine\RelativeGeo\Address;

class AddressTest extends TestCase {

    /** @test */
    public function instantiate_address () {
        $address = "Toulouse";
        $a = new Address($address);

        $this->assertEquals($address, $a->address);
    }

}