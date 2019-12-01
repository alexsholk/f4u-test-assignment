<?php


namespace App\Tests\Shipping\Domain\Model\ShippingAddress;

use App\Shipping\Domain\Model\ShippingAddress\Street;
use PHPUnit\Framework\TestCase;

class StreetTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateStreetWithShortName()
    {
        Street::create(str_repeat('a', 2));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateStreetWithLongName()
    {
        Street::create(str_repeat('a', 101));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateStreetWithInvalidCharsInName()
    {
        Street::create('12345');
    }

    /**
     * @test
     */
    public function createStreetWithAccentedCharsInName()
    {
        $street = Street::create('Avenue des Champs-Élysées');
        $this->assertSame('Avenue des Champs-Élysées', $street->name());
    }

    /**
     * @test
     */
    public function createStreet()
    {
        $street = Street::create('Avenue de L\'Opéra');
        $this->assertInstanceOf(Street::class, $street);
        $this->assertSame('Avenue de L\'Opéra', $street->name());
        return $street;
    }

    /**
     * @test
     * @depends createStreet
     * @expectedException \Error
     * @param $street
     */
    public function streetIsImmutable($street)
    {
        $street->setName('Rue de la Paix');
    }

    /**
     * @test
     */
    public function equals()
    {
        $street1 = Street::create('Avenue de L\'Opéra');
        $street2 = Street::create('Avenue de L\'Opéra');
        $street3 = Street::create('Rue de la Paix');
        $this->assertTrue($street1->equals($street2));
        $this->assertFalse($street1->equals($street3));
    }
}