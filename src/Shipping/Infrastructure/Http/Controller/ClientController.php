<?php


namespace App\Shipping\Infrastructure\Http\Controller;

use App\Shipping\Domain\Model\Client\ClientId;
use App\Shipping\Domain\Service\ClientService;
use App\Shipping\Domain\Service\DTO\ClientDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route(path="/clients", name="client")
 */
class ClientController
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * @Route("/", methods={"GET"}, name="list")
     * @return JsonResponse
     */
    public function list()
    {
        $clients = $this->clientService->listClients();
        return new JsonResponse($clients);
    }

    /**
     * @Route("/", methods={"POST"}, name="create")
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $clientDTO = new ClientDTO(
            $request->request->get('first_name'),
            $request->request->get('last_name')
        );

        $clientId = $this->clientService->createClient($clientDTO);
        return new JsonResponse($clientId, Response::HTTP_CREATED);
    }

    /**
     * @Route("/{id}", methods={"DELETE"}, name="delete")
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $this->clientService->deleteClient(ClientId::create($id));
        return new JsonResponse(null, Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="view")
     * @param $id
     * @return JsonResponse
     */
    public function view($id)
    {
        $client = $this->clientService->findClient(ClientId::create($id));
        return new JsonResponse($client);
    }

    /**
     * @Route("/{id}/addresses", methods={"GET"}, name="addresses")
     * @param $id
     * @return JsonResponse
     */
    public function addressList($id)
    {
        $client = $this->clientService->findClient(ClientId::create($id));
        return new JsonResponse($client->jsonSerialize()['shipping_address_list']);
    }
}