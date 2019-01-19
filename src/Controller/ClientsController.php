<?php

namespace App\Controller;

use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientsController extends Controller
{
    /**
     * @Route("/account/clients/list", name="clients_list")
     * @return Response
     */
    public function listAction(): Response
    {
        $em = $this->getDoctrine()->getManager();
        $clients = $em->getRepository(Client::class)->findAll();

        return $this->render(
            'clients/list.html.twig',
            [
                'clients' => $clients
            ]
        );
    }
}
