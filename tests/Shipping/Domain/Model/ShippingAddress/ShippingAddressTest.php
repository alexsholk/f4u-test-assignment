<?php


namespace App\Tests\Shipping\Domain\Model\ShippingAddress;

use App\Shipping\Domain\Model\ShippingAddress\City;
use App\Shipping\Domain\Model\ShippingAddress\Country;
use App\Shipping\Domain\Model\ShippingAddress\ShippingAddress;
use App\Shipping\Domain\Model\ShippingAddress\Street;
use App\Shipping\Domain\Model\ShippingAddress\Zipcode;
use PHPUnit\Framework\TestCase;

class ShippingAddressTest extends TestCase
{
    /**
     * @test
     */
    public function createShippingAddress()
    {
        $shippingAddress = ShippingAddress::create(
            Country::create('Belarus'),
            City::create('Minsk'),
            Zipcode::create('220090'),
            Street::create('Logojskij trakt')
        );

        $this->assertInstanceOf(ShippingAddress::class, $shippingAddress);
        $this->assertSame('Belarus', $shippingAddress->country()->name());
        $this->assertSame('Minsk', $shippingAddress->city()->name());
        $this->assertSame('220090', $shippingAddress->zipcode()->value());
        $this->assertSame('Logojskij trakt', $shippingAddress->street()->name());
        return $shippingAddress;
    }

    /**
     * @test
     * @depends createShippingAddress
     * @expectedException \Error
     * @param $shippingAddress
     */
    public function shippingAddressCountryIsImmutable($shippingAddress)
    {
        $shippingAddress->setCountry(Country::create('Argentina'));
    }

    /**
     * @test
     * @depends createShippingAddress
     * @expectedException \Error
     * @param $shippingAddress
     */
    public function shippingAddressCityIsImmutable($shippingAddress)
    {
        $shippingAddress->setCity(City::create('Buenos Aires'));
    }

    /**
     * @test
     * @depends createShippingAddress
     * @expectedException \Error
     * @param $shippingAddress
     */
    public function shippingAddressZipcodeIsImmutable($shippingAddress)
    {
        $shippingAddress->setZipcode(Zipcode::create('B1675'));
    }

    /**
     * @test
     * @depends createShippingAddress
     * @expectedException \Error
     * @param $shippingAddress
     */
    public function shippingAddressStreetIsImmutable($shippingAddress)
    {
        $shippingAddress->setStreet(Street::create('9 de Julio Avenue'));
    }

    /**
     * @test
     */
    public function equals()
    {
        $shippingAddress1 = ShippingAddress::create(
            Country::create('Belarus'),
            City::create('Minsk'),
            Zipcode::create('220090'),
            Street::create('Logojskij trakt')
        );

        $shippingAddress2 = ShippingAddress::create(
            Country::create('Belarus'),
            City::create('Minsk'),
            Zipcode::create('220090'),
            Street::create('Logojskij trakt')
        );

        $shippingAddress3 = ShippingAddress::create(
            Country::create('France'),
            City::create('Paris'),
            Zipcode::create('123098'),
            Street::create('Rue de la Paix')
        );

        $this->assertTrue($shippingAddress1->equals($shippingAddress2));
        $this->assertFalse($shippingAddress1->equals($shippingAddress3));
    }
}