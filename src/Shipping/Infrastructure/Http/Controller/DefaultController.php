<?php


namespace App\Shipping\Infrastructure\Http\Controller;

use Symfony\Component\Routing\Annotation\Route;

class DefaultController
{
    /**
     * @Route("/", methods={"GET"}, name="homepage")
     */
    public function index()
    {
        // @todo SPA
        die('homepage');
    }
}