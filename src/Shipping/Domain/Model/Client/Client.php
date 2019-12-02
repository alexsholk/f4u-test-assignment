<?php


namespace App\Shipping\Domain\Model\Client;


class Client implements \JsonSerializable
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

    public function changeFirstName(string $firstName)
    {
        $this->fullName = FullName::create($firstName, $this->fullName()->lastName());
    }

    public function changeLastName(string $lastName)
    {
        $this->fullName = FullName::create($this->fullName()->firstName(), $lastName);
    }

    public function shippingAddressList(): ShippingAddressList
    {
        return $this->shippingAddressList;
    }

    public function jsonSerialize()
    {
        $clientData = [
            'client_id'  => $this->clientId()->id(),
            'first_name' => $this->fullName()->firstName(),
            'last_name'  => $this->fullName()->lastName(),
        ];

        $shippingAddressData = [];
        foreach ($this->shippingAddressList->all() as $shippingAddress) {
            $item            = $shippingAddress->jsonSerialize();
            $item['default'] = $shippingAddress->equals($this->shippingAddressList->default());
            $shippingAddressData[] = $item;
        }
        $clientData['shipping_address_list'] = $shippingAddressData;

        return $clientData;
    }

    public static function create(ClientId $clientId, FullName $fullName): self
    {
        return new self($clientId, $fullName);
    }
}