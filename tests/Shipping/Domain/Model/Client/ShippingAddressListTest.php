<?php


namespace App\Tests\Shipping\Domain\Model\Client;

use App\Shipping\Domain\Model\Client\ShippingAddressList;
use App\Shipping\Domain\Model\ShippingAddress\City;
use App\Shipping\Domain\Model\ShippingAddress\Country;
use App\Shipping\Domain\Model\ShippingAddress\ShippingAddress;
use App\Shipping\Domain\Model\ShippingAddress\Street;
use App\Shipping\Domain\Model\ShippingAddress\Zipcode;
use PHPUnit\Framework\TestCase;

class ShippingAddressListTest extends TestCase
{
    /**
     * @test
     * @return ShippingAddressList
     */
    public function createEmpty()
    {
        $list = ShippingAddressList::create(3);

        $this->assertNull($list->default());
        $this->assertCount(0, $list->all());
        return $list;
    }

    /**
     * @test
     * @depends createEmpty
     * @param ShippingAddressList $list
     */
    public function basicFunctionality(ShippingAddressList $list)
    {
        $shippingAddress1 = $this->shippingAddresses()[0];

        $list->add($shippingAddress1);
        $this->assertCount(1, $list->all());
        $this->assertTrue($list->exists($shippingAddress1));
        $this->assertSame($shippingAddress1, $list->default());

        try {
            $list->add($shippingAddress1);
            $this->assertTrue(false);
        } catch (\RuntimeException $exception) {
            $this->assertEquals('shipping_address_list.list.already_exists', $exception->getMessage());
        }

        $shippingAddress2 = $this->shippingAddresses()[1];
        $list->add($shippingAddress2);
        $this->assertCount(2, $list->all());
        $this->assertSame($shippingAddress1, $list->default());

        $list->setDefault($shippingAddress2);
        $this->assertSame($shippingAddress2, $list->default());

        try {
            $list->remove($shippingAddress2);
            $this->assertTrue(false);
        } catch (\RuntimeException $exception) {
            $this->assertEquals('shipping_address_list.list.cannot_remove_default', $exception->getMessage());
        }

        $list->remove($shippingAddress1);
        $this->assertCount(1, $list->all());
        $this->assertSame($shippingAddress2, $list->default());
    }

    private function shippingAddresses()
    {
        return [
            ShippingAddress::create(
                Country::create('Belarus'),
                City::create('Minsk'),
                Zipcode::create('220090'),
                Street::create('Logojskij trakt')
            ),
            ShippingAddress::create(
                Country::create('France'),
                City::create('Paris'),
                Zipcode::create('123098'),
                Street::create('Rue de la Paix')
            )
        ];
    }
}