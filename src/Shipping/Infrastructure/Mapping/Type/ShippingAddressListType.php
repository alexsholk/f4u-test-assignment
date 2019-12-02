<?php


namespace App\Shipping\Infrastructure\Mapping\Type;

use App\Shipping\Domain\Model\Client\Client;
use App\Shipping\Domain\Model\Client\ShippingAddressList;
use App\Shipping\Domain\Model\ShippingAddress\ShippingAddress;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\JsonType;

class ShippingAddressListType extends JsonType
{
    const NAME = 'shipping_address_list';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        $data = [];
        foreach ($value->all() as $shippingAddress) {
            $data[] = [
                'country' => $shippingAddress->country()->name(),
                'city'    => $shippingAddress->city()->name(),
                'zipcode' => $shippingAddress->zipcode()->value(),
                'street'  => $shippingAddress->street()->name(),
                'default' => $shippingAddress->equals($value->default()),
            ];
        }

        $encoded = json_encode($data);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ConversionException::conversionFailedSerialization($value, 'json', json_last_error_msg());
        }

        return $encoded;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }

        $val = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        $shippingAddressList = ShippingAddressList::create(Client::SHIPPING_ADDRESS_LIST_MAX_COUNT);
        if ($val instanceof \iterable) {
            foreach ($val as $item) {
                $shippingAddress = ShippingAddress::create(
                    $item['country'],
                    $item['city'],
                    $item['zipcode'],
                    $item['street']
                );
                $shippingAddressList->add($shippingAddress);
                if ($item['default']) {
                    $shippingAddressList->setDefault($shippingAddress);
                }
            }
        }

        return $shippingAddressList;
    }
}