<?php


namespace App\Shipping\Domain\Model\ShippingAddress;


class City
{
    const NAME_REGEX = "/^[\\p{L}\\'\\- ]{3,100}$/u";

    private $name;

    private function __construct(string $name)
    {
        $this->setName($name);
    }

    private function setName(string $name)
    {
        $this->assertNameIsValid($name);
        $this->name = $name;
    }

    private function assertNameIsValid(string $name)
    {
        if (!preg_match(self::NAME_REGEX, $name)) {
            throw new \InvalidArgumentException('city.name.invalid');
        }
    }

    public function name(): string
    {
        return $this->name;
    }

    public function equals(self $city)
    {
        return $this->name() === $city->name();
    }

    public static function create(string $name): self
    {
        return new self($name);
    }
}