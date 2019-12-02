<?php


namespace App\Shipping\Domain\Service;

use App\Shipping\Domain\Model\Client\Client;
use App\Shipping\Domain\Model\Client\ClientId;
use App\Shipping\Domain\Model\Client\FullName;
use App\Shipping\Domain\Model\ShippingAddress\City;
use App\Shipping\Domain\Model\ShippingAddress\Country;
use App\Shipping\Domain\Model\ShippingAddress\ShippingAddress;
use App\Shipping\Domain\Model\ShippingAddress\Street;
use App\Shipping\Domain\Model\ShippingAddress\Zipcode;
use App\Shipping\Domain\Repository\ClientRepository;
use App\Shipping\Domain\Service\DTO\ClientDTO;
use App\Shipping\Domain\Service\DTO\ShippingAddressDTO;
use App\Shipping\Domain\Service\Exception\ClientNotFoundException;

class ClientService
{
    private $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param ClientDTO $clientDTO
     * @return ClientId
     */
    public function createClient(ClientDTO $clientDTO): ClientId
    {
        $client = $this->convertClientDTOtoClient($clientDTO);
        $this->saveClient($client);
        return $client->clientId();
    }

    /**
     * @param ClientId $clientId
     * @param ClientDTO $clientDTO
     */
    public function updateClient(ClientId $clientId, ClientDTO $clientDTO)
    {
        $client = $this->findClient($clientId);
        $client->changeFirstName($clientDTO->getFirstName());
        $client->changeLastName($clientDTO->getLastName());
        $this->saveClient($client);
    }

    /**
     * @param ClientId $clientId
     */
    public function deleteClient(ClientId $clientId)
    {
        $this->clientRepository->delete($clientId);
    }

    /**
     * @param ClientId $clientId
     * @param ShippingAddressDTO $shippingAddressDTO
     */
    public function addShippingAddress(ClientId $clientId, ShippingAddressDTO $shippingAddressDTO)
    {
        $client = $this->findClient($clientId);
        $shippingAddress = $this->convertShippingAddressDTOtoShippingAddress($shippingAddressDTO);

        if (!$client->shippingAddressList()->exists($shippingAddress)) {
            $client->shippingAddressList()->add($shippingAddress);
        }

        if ($shippingAddressDTO->isDefault()) {
            $client->shippingAddressList()->setDefault($shippingAddress);
        }

        $this->saveClient($client);
    }

    /**
     * @param ClientId $clientId
     * @param ShippingAddressDTO $shippingAddressDTO
     */
    public function removeShippingAddress(ClientId $clientId, ShippingAddressDTO $shippingAddressDTO)
    {
        $client = $this->findClient($clientId);
        $shippingAddress = $this->convertShippingAddressDTOtoShippingAddress($shippingAddressDTO);

        $client->shippingAddressList()->remove($shippingAddress);
        $this->saveClient($client);
    }

    /**
     * @param ClientId $clientId
     */
    public function clearShippingAddresses(ClientId $clientId)
    {
        $client = $this->findClient($clientId);
        $client->shippingAddressList()->clear();
        $this->saveClient($client);
    }

    /**
     * @param ClientId $clientId
     * @return Client
     */
    public function findClient(ClientId $clientId): Client
    {
        if (!$client = $this->clientRepository->findById($clientId)) {
            throw new ClientNotFoundException('client_service.client_not_found');
        }
        return $client;
    }

    /**
     * @return Client[]
     */
    public function listClients()
    {
        return $this->clientRepository->list();
    }

    /**
     * @param Client $client
     */
    private function saveClient(Client $client)
    {
        $this->clientRepository->save($client);
    }

    /**
     * @param ClientDTO $clientDTO
     * @return Client
     */
    private function convertClientDTOtoClient(ClientDTO $clientDTO)
    {
        return Client::create(
            $this->clientRepository->generateId(),
            FullName::create(
                $clientDTO->getFirstName(),
                $clientDTO->getLastName()
            )
        );
    }

    /**
     * @param ShippingAddressDTO $shippingAddressDTO
     * @return ShippingAddress
     */
    private function convertShippingAddressDTOtoShippingAddress(ShippingAddressDTO $shippingAddressDTO)
    {
        return ShippingAddress::create(
            Country::create($shippingAddressDTO->getCountry()),
            City::create($shippingAddressDTO->getCity()),
            Zipcode::create($shippingAddressDTO->getZipcode()),
            Street::create($shippingAddressDTO->getCity())
        );
    }
}