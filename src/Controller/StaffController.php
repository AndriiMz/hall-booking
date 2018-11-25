<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaffController extends Controller
{
    /**
     * @Route("/account/staff/list", name="staff_list")
     * @return Response
     */
    public function listAction(): Response
    {


        return $this->render(
            'staff/list.html.twig'
        );
    }

}
