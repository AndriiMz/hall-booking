<?php

namespace App\Controller;

use App\Enum\RequestTypeEnum;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * @var RegistrationService
     */
    private $registrationService;

    /**
     * UserController constructor.
     * @param RegistrationService $registrationService
     */
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * @Route("/profile/edit", name="profile_edit")
     * @param Request $request
     * @return Response
     */
    public function editAction(Request $request): Response
    {
        $user = $this->getUser();
        $msg = null;
        if ($request->isMethod(RequestTypeEnum::POST)) {

            $this->registrationService->updateFromRequest($user, $request);
            $msg = 'Dane zapisano!';
        }

        return $this->render(
            'user/edit.html.twig',
            [
                'user' => $user,
                'msg' => $msg
            ]
        );
    }

}
