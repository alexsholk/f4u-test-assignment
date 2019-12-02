<?php


namespace App\Shipping\Domain\Repository;

use App\Shipping\Domain\Model\Client\Client;
use App\Shipping\Domain\Model\Client\ClientId;

interface ClientRepository
{
    public function generateId(): ClientId;

    public function findById(ClientId $clientId): Client;

    public function save(Client $client);

    public function list();

    public function delete(ClientId $clientId);
}