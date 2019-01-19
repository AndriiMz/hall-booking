<?php

namespace App\Controller;

use App\Enum\RequestTypeEnum;
use App\Repository\UserRepository;
use App\Service\RegistrationService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @var RegistrationService
     */
    private $registrationService;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(
        RegistrationService $registrationService,
        UserRepository $userRepository
    ) {
        $this->registrationService = $registrationService;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authUtils
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig',
            array(
                'last_username' => $lastUsername,
                'error'         => $error,
            )
        );
    }

    /**
     * @Route("/registration", name="registration")
     * @param Request $request
     * @return Response
     */
    public function registrationAction(Request $request): Response
    {
        $errors = [];

        if ($request->isMethod(RequestTypeEnum::POST)) {
            try {
                $user = $this->registrationService->fromRequest($request);
            } catch (\Exception $e) {
                $errors[] = $e->getMessage();
            }

            if (empty($errors)) {
                return $this->redirectToRoute(
                    'registration_success',
                    [
                        'id' => $user->getId()
                    ]
                );
            }
        }

        return $this->render(
            'security/registration.html.twig',
            [
                'errors' => implode(',', $errors),
                'request' => $request
            ]
        );
    }

    /**
     * @Route("/registration-success/{id}", name="registration_success", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function registrationSuccessAction($id): Response
    {
        $user = $this->userRepository->find($id);


        return $this->render(
            'security/registration-success.html.twig',
            ['user' => $user]
        );
    }

}
