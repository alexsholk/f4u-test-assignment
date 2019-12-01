<?php


namespace App\Shipping\Domain\Model\Client;


class Client
{
    const SHIPPING_ADDRESS_LIST_MAX_COUNT = 3;

    private $clientId;
    private $fullName;
    private $shippingAddressList;

    private function __construct(ClientId $clientId, FullName $fullName)
    {
        $this->clientId            = $clientId;
        $this->fullName            = $fullName;
        $this->shippingAddressList = ShippingAddressList::create(self::SHIPPING_ADDRESS_LIST_MAX_COUNT);
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

    public function shippingAddressList(): ShippingAddressList
    {
        return $this->shippingAddressList;
    }

    public static function create(ClientId $clientId, FullName $fullName): self
    {
        return new self($clientId, $fullName);
    }
}