<?php


namespace App\Shipping\Domain\Model\ShippingAddress;


class Zipcode
{
    const ZIPCODE_REGEX = "/^[A-Za-z0-9- ]{3,10}$/";

    private $value;

    private function __construct(string $value)
    {
        $this->setValue($value);
    }

    private function setValue(string $name)
    {
        $this->assertValueIsValid($name);
        $this->value = $name;
    }

    private function assertValueIsValid(string $name)
    {
        if (!preg_match(self::ZIPCODE_REGEX, $name)) {
            throw new \InvalidArgumentException('zipcode.value.invalid');
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(self $zipcode)
    {
        return $this->value() === $zipcode->value();
    }

    public static function create(string $value): self
    {
        return new self($value);
    }
}