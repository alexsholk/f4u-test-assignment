<?php


namespace App\Shipping\Infrastructure\Mapping\Type;

use App\Shipping\Domain\Model\Client\ClientId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use InvalidArgumentException;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\Uuid;

class ClientIdType extends UuidType
{
    const NAME = 'client_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof ClientId) {
            return $value;
        }

        try {
            $clientId = ClientId::create(Uuid::fromString($value));
        } catch (InvalidArgumentException $e) {
            throw ConversionException::conversionFailed($value, static::NAME);
        }

        return $clientId;
    }
}