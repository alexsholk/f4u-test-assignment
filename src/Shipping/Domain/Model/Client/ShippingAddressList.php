<?php


namespace App\Shipping\Domain\Model\Client;

use App\Shipping\Domain\Model\ShippingAddress\ShippingAddress;

class ShippingAddressList
{
    private $maxCount;

    /** @var ShippingAddress[] */
    private $list = [];
    /** @var ShippingAddress */
    private $default;

    private function __construct(int $maxCount)
    {
        if ($maxCount < 1) {
            throw new \InvalidArgumentException('shipping_address_list.max_count.invalid');
        }
        $this->maxCount = $maxCount;
    }

    private function __clone()
    {
        // Deny clone
    }

    public function add(ShippingAddress $shippingAddress)
    {
        if (count($this->list) >= $this->maxCount) {
            throw new \RuntimeException('shipping_address_list.list.overflow');
        }

        if ($this->exists($shippingAddress)) {
            throw new \RuntimeException('shipping_address_list.list.already_exists');
        }

        $this->list[] = $shippingAddress;
        if (!$this->default) {
            $this->setDefault($shippingAddress);
        }
    }

    public function setDefault(ShippingAddress $shippingAddress)
    {
        if (!$this->exists($shippingAddress)) {
            throw new \InvalidArgumentException('shipping_address_list.list.not_exists');
        }

        $this->default = $shippingAddress;
    }

    public function remove(ShippingAddress $shippingAddress)
    {
        if (!$this->exists($shippingAddress)) {
            throw new \InvalidArgumentException('shipping_address_list.list.not_exists');
        }

        if ($this->default && $this->default->equals($shippingAddress)) {
            throw new \RuntimeException('shipping_address_list.list.cannot_remove_default');
        }

        foreach ($this->list as $i => $item) {
            if ($item->equals($shippingAddress)) {
                unset($this->list[$i]);
                break;
            }
        }
    }

    public function exists(ShippingAddress $shippingAddress): bool
    {
        foreach ($this->list as $item) {
            if ($item->equals($shippingAddress)) {
                return true;
            }
        }
        return false;
    }

    public function default(): ?ShippingAddress
    {
        return $this->default;
    }

    /**
     * @return ShippingAddress[]
     */
    public function all(): array
    {
        return $this->list;
    }

    public static function create(int $maxCount): self
    {
        return new self($maxCount);
    }
}