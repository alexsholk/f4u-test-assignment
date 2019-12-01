<?php


namespace App\Shipping\Domain\Model\Client;


class Client
{
    private $clientId;
    private $fullName;

    private function __construct(ClientId $clientId, FullName $fullName)
    {
        $this->clientId = $clientId;
        $this->fullName = $fullName;
    }

    private function __clone()
    {
        // Deny clone
    }

    public function clientId(): ClientId
    {
        return $this->clientId;
    }

    public function fullName(): FullName
    {
        return $this->fullName;
    }

    public static function create(ClientId $clientId, FullName $fullName): self
    {
        return new self($clientId, $fullName);
    }
}