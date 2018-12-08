<?php

namespace App\Controller;

use App\Service\BookingService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends Controller
{
    /**
     * @var BookingService
     */
    private $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    /**
     * @Route("/account/bookings/list", name="bookings_list")
     * @return Response
     */
    public function listAction(): Response
    {
        $bookings = $this->bookingService->getList();

        return $this->render(
            'bookings/list.html.twig',
            [
                'bookings' => $bookings
            ]
        );
    }

}
