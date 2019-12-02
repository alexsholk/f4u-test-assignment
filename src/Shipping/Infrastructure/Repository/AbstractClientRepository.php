<?php


namespace App\Shipping\Infrastructure\Repository;

use App\Shipping\Domain\Model\Client\ClientId;
use App\Shipping\Domain\Repository\ClientRepository;
use Ramsey\Uuid\Uuid;

abstract class AbstractClientRepository implements ClientRepository
{
    public function generateId(): ClientId
    {
        return ClientId::create(Uuid::uuid4()->toString());
    }
}