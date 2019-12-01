<?php


namespace App\Tests\Shipping\Domain\Model\ShippingAddress;

use App\Shipping\Domain\Model\ShippingAddress\City;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateCityWithShortName()
    {
        City::create(str_repeat('a', 2));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateCityWithLongName()
    {
        City::create(str_repeat('a', 101));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateCityWithInvalidCharsInName()
    {
        City::create('12345');
    }

    /**
     * @test
     */
    public function createCityWithAccentedCharsInName()
    {
        $city = City::create('Asnières-sur-Seine');
        $this->assertSame('Asnières-sur-Seine', $city->name());
    }

    /**
     * @test
     */
    public function createCity()
    {
        $city = City::create('Berlin');
        $this->assertInstanceOf(City::class, $city);
        $this->assertSame('Berlin', $city->name());
        return $city;
    }

    /**
     * @test
     * @depends createCity
     * @expectedException \Error
     * @param $city
     */
    public function cityIsImmutable($city)
    {
        $city->setName('Paris');
    }

    /**
     * @test
     */
    public function equals()
    {
        $city1 = City::create('Berlin');
        $city2 = City::create('Berlin');
        $city3 = City::create('Paris');
        $this->assertTrue($city1->equals($city2));
        $this->assertFalse($city1->equals($city3));
    }
}