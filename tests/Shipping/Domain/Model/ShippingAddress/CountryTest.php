<?php


namespace App\Tests\Shipping\Domain\Model\ShippingAddress;

use App\Shipping\Domain\Model\ShippingAddress\Country;
use PHPUnit\Framework\TestCase;

class CountryTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateCountryWithShortName()
    {
        Country::create(str_repeat('a', 2));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateCountryWithLongName()
    {
        Country::create(str_repeat('a', 101));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateCountryWithInvalidCharsInName()
    {
        Country::create('12345');
    }

    /**
     * @test
     */
    public function createCountryWithAccentedCharsInName()
    {
        $country = Country::create('Côte d\'Ivoire');
        $this->assertSame('Côte d\'Ivoire', $country->name());
    }

    /**
     * @test
     */
    public function createCountry()
    {
        $country = Country::create('Democratic Republic of the Congo');
        $this->assertInstanceOf(Country::class, $country);
        $this->assertSame('Democratic Republic of the Congo', $country->name());
        return $country;
    }

    /**
     * @test
     * @depends createCountry
     * @expectedException \Error
     * @param $country
     */
    public function countryIsImmutable($country)
    {
        $country->setName('Barbados');
    }

    /**
     * @test
     */
    public function equals()
    {
        $country1 = Country::create('Germany');
        $country2 = Country::create('Germany');
        $country3 = Country::create('France');
        $this->assertTrue($country1->equals($country2));
        $this->assertFalse($country1->equals($country3));
    }
}