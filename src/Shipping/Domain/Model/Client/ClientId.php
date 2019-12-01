<?php


namespace App\Shipping\Domain\Model\Client;


class ClientId
{
    const ID_MIN_LENGTH = 16;
    const ID_MAX_LENGTH = 80;

    private $id;
    private static $pool;

    private function __construct(string $id)
    {
        $this->setId($id);
    }

    private function __clone()
    {
        // Deny clone
    }

    private function setId(string $id)
    {
        $this->assertIdIsValid($id);
        $this->id = $id;
    }

    private function assertIdIsValid(string $id)
    {
        if (strlen($id) < self::ID_MIN_LENGTH ||
            strlen($id) > self::ID_MAX_LENGTH
        ) {
            throw new \InvalidArgumentException('client_id.id.invalid');
        }
    }

    public function id(): string
    {
        return $this->id;
    }

    public static function create(string $id): self
    {
        // Flyweight pattern
        if (!isset(self::$pool[$id])) {
            self::$pool[$id] = new self($id);
        }

        return self::$pool[$id];
    }
}