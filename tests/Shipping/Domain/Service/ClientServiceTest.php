<?php


namespace App\Tests\Shipping\Domain\Service;

use App\Shipping\Domain\Service\ClientService;
use App\Shipping\Domain\Service\DTO\ClientDTO;
use App\Shipping\Infrastructure\Repository\InMemoryClientRepository;
use PHPUnit\Framework\TestCase;

class ClientServiceTest extends TestCase
{
    /** @var ClientService */
    private $clientService;

    protected function setUp()
    {
        $this->clientService = new ClientService(new InMemoryClientRepository());
    }

    /**
     * @test
     */
    public function createClient()
    {
        $clientDTO = new ClientDTO('John', 'Smith');
        $clientId  = $this->clientService->createClient($clientDTO);
        $client    = $this->clientService->findClient($clientId);

        $this->assertSame('John', $client->fullName()->firstName());
        $this->assertSame('Smith', $client->fullName()->lastName());

        return $clientId;
    }

    /**
     * @test
     */
    public function updateClient()
    {
        $clientDTO = new ClientDTO('John', 'Smith');
        $clientId  = $this->clientService->createClient($clientDTO);

        $this->clientService->updateClient($clientId, new ClientDTO('David', 'Duchovny'));
        $client = $this->clientService->findClient($clientId);

        $this->assertSame($clientId->id(), $client->clientId()->id());
        $this->assertSame('David', $client->fullName()->firstName());
        $this->assertSame('Duchovny', $client->fullName()->lastName());
    }
}