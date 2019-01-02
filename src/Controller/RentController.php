<?php

namespace App\Controller;

use App\Service\RentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RentController extends Controller
{
    /**
     * @var RentService
     */
    private $rentService;

    public function __construct(RentService $rentService)
    {
        $this->rentService = $rentService;
    }

    /**
     * @Route("/account/rents/list", name="rents_list")
     * @return Response
     */
    public function listAction(): Response
    {
        $rents = $this->rentService->getList(
            $this->getUser()
        );

        return $this->render(
            'rent/list.html.twig',
            [
                'rents' => $rents
            ]
        );
    }

}
