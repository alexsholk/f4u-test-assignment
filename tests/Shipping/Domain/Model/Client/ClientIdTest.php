<?php


namespace App\Tests\Shipping\Domain\Model\Client;

use App\Shipping\Domain\Model\Client\ClientId;
use PHPUnit\Framework\TestCase;

class ClientIdTest extends TestCase
{
    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateClientIdWithShortId()
    {
        ClientId::create(str_repeat('a', 2));
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function cannotCreateClientIdWithLongId()
    {
        ClientId::create(str_repeat('a', 81));
    }

    /**
     * @test
     */
    public function create()
    {
        $clientId = ClientId::create(md5('id'));
        $this->assertSame(md5('id'), $clientId->id());
    }

    /**
     * @test
     */
    public function equals()
    {
        $clientId1 = ClientId::create(md5('id'));
        $clientId2 = ClientId::create(md5('id'));
        $clientId3 = ClientId::create(md5('another_id'));
        $this->assertSame($clientId1, $clientId2);
        $this->assertNotSame($clientId1, $clientId3);
    }
}