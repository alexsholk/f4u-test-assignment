<?php


namespace App\Shipping\Domain\Model\ShippingAddress;


class ShippingAddress
{
    private $country;
    private $city;
    private $zipcode;
    private $street;

    private function __construct(Country $country, City $city, Zipcode $zipcode, Street $street)
    {
        $this->country = $country;
        $this->city    = $city;
        $this->zipcode = $zipcode;
        $this->street  = $street;
    }

    public function country(): Country
    {
        return $this->country;
    }

    public function city(): City
    {
        return $this->city;
    }

    public function zipcode(): Zipcode
    {
        return $this->zipcode;
    }

    public function street(): Street
    {
        return $this->street;
    }

    public function equals(self $shippingAddress)
    {
        return $this->country()->equals($shippingAddress->country())
            && $this->city()->equals($shippingAddress->city())
            && $this->zipcode()->equals($shippingAddress->zipcode())
            && $this->street()->equals($shippingAddress->street());
    }

    public static function create(Country $country, City $city, Zipcode $zipcode, Street $street): self
    {
        return new self($country, $city, $zipcode, $street);
    }
}