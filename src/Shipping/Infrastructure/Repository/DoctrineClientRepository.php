<?php


namespace App\Shipping\Infrastructure\Repository;

use App\Shipping\Domain\Model\Client\Client;
use App\Shipping\Domain\Model\Client\ClientId;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineClientRepository extends AbstractClientRepository
{
    private $entityManager;
    private $repository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository    = $entityManager->getRepository(Client::class);
    }

    public function findById(ClientId $clientId): Client
    {
        return $this->repository->find($clientId);
    }

    public function save(Client $client)
    {
        $this->entityManager->persist($client);
        $this->entityManager->flush();
    }

    public function list()
    {
        return $this->repository->findAll();
    }

    public function delete(ClientId $clientId)
    {
        $client = $this->findById($clientId);
        $this->entityManager->remove($client);
        $this->entityManager->flush();
    }
}