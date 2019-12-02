<?php


namespace App\Shipping\Domain\Service\DTO;


class ShippingAddressDTO
{
    private $country;
    private $city;
    private $zipcode;
    private $street;
    private $default;

    public function __construct(string $country, string $city, string $zipcode, string $street, bool $default = false)
    {
        $this->country = $country;
        $this->city    = $city;
        $this->zipcode = $zipcode;
        $this->street  = $street;
        $this->default = $default;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function isDefault(): bool
    {
        return $this->default;
    }
}