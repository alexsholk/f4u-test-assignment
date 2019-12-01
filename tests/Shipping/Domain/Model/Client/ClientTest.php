<?php


namespace App\Tests\Shipping\Domain\Model\Client;

use App\Shipping\Domain\Model\Client\Client;
use App\Shipping\Domain\Model\Client\ClientId;
use App\Shipping\Domain\Model\Client\FullName;
use App\Shipping\Domain\Model\Client\ShippingAddressList;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function createWithoutShippingAddressList()
    {
        $client = Client::create(
            ClientId::create(md5('id')),
            FullName::create('John', 'Smith')
        );

        $this->assertInstanceOf(ShippingAddressList::class, $client->shippingAddressList());
    }
}