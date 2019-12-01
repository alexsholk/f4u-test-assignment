<?php


namespace App\Shipping\Domain\Model\Client;


class FullName
{
    const FIRST_NAME_REGEX = "/^[\\p{L}\\'\\-]{2,50}$/u";
    const LAST_NAME_REGEX  = self::FIRST_NAME_REGEX;

    private $firstName;
    private $lastName;

    private function __construct(string $firstName, string $lastName)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    private function setFirstName(string $firstName)
    {
        if (!preg_match(self::FIRST_NAME_REGEX, $firstName)) {
            throw new \InvalidArgumentException('full_name.first_name.invalid');
        }
        $this->firstName = $firstName;
    }

    private function setLastName(string $lastName)
    {
        if (!preg_match(self::LAST_NAME_REGEX, $lastName)) {
            throw new \InvalidArgumentException('full_name.last_name.invalid');
        }
        $this->lastName = $lastName;
    }

    public function firstName(): string
    {
        return $this->firstName;
    }

    public function lastName(): string
    {
        return $this->lastName;
    }

    public function equals(self $fullName)
    {
        return $this->firstName() === $fullName->firstName()
            && $this->lastName() === $fullName->lastName();
    }

    public static function create(string $firstName, string $lastName): self
    {
        return new self($firstName, $lastName);
    }
}