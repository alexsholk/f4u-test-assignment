<?php


namespace App\Tests\Shipping\Domain\Model\ShippingAddress;

use App\Shipping\Domain\Model\ShippingAddress\Zipcode;
use PHPUnit\Framework\TestCase;

class ZipcodeTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateZipcodeWithShortValue()
    {
        Zipcode::create(str_repeat('a', 2));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateZipcodeWithLongValue()
    {
        Zipcode::create(str_repeat('a', 11));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateZipcodeWithInvalidCharsInValue()
    {
        Zipcode::create('{]_');
    }

    /**
     * @test
     */
    public function createZipcode()
    {
        $zipcode = Zipcode::create('220090');
        $this->assertInstanceOf(Zipcode::class, $zipcode);
        $this->assertSame('220090', $zipcode->value());
        return $zipcode;
    }

    /**
     * @test
     * @depends createZipcode
     * @expectedException \Error
     * @param $zipcode
     */
    public function cityIsImmutable($zipcode)
    {
        $zipcode->setValue('220091');
    }

    /**
     * @test
     */
    public function equals()
    {
        $zipcode1 = Zipcode::create('220090');
        $zipcode2 = Zipcode::create('220090');
        $zipcode3 = Zipcode::create('220091');
        $this->assertTrue($zipcode1->equals($zipcode2));
        $this->assertFalse($zipcode1->equals($zipcode3));
    }
}