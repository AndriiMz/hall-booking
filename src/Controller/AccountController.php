<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Service\BookingService;
use App\Service\RentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends Controller
{
    /**
     * @var BookingService
     */
    private $bookingService;
    /**
     * @var RentService
     */
    private $rentService;

    public function __construct(
        BookingService $bookingService,
        RentService $rentService
    )
    {
        $this->bookingService = $bookingService;
        $this->rentService = $rentService;
    }

    /**
     * @Route("/account", name="account")
     * @return Response
     */
    public function indexAction(): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $bookings = [];
        $rents = [];

        if ($user->getRole() === UserRoleEnum::CLIENT_ROLE) {
            $bookings = $this->bookingService->getList($user);
            $rents = $this->rentService->getList($user);
        }


        return $this->render(
            'account/index.html.twig',
            [
                'bookings' => $bookings,
                'rents' => $rents
            ]
        );
    }

}
