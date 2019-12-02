<?php


namespace App\Shipping\Infrastructure\Repository;

use App\Shipping\Domain\Model\Client\Client;
use App\Shipping\Domain\Model\Client\ClientId;

class InMemoryClientRepository extends AbstractClientRepository
{
    private $clients = [];

    public function findById(ClientId $clientId): Client
    {
        return $this->clients[$clientId->id()] ?? null;
    }

    public function save(Client $client)
    {
        $this->clients[$client->clientId()->id()] = $client;
    }

    public function list()
    {
        return $this->clients;
    }

    public function delete(ClientId $clientId)
    {
        unset($this->clients[$clientId->id()]);
    }
}