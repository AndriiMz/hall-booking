<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @Route("/account", name="account")
     * @return Response
     */
    public function indexAction(): Response
    {

        return $this->render('account/index.html.twig');
    }

}
