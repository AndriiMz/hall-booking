<?php

namespace App\Controller;

use App\Service\BookingService;
use App\Service\RentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookingsController extends Controller
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

    /**
     * @Route("/account/booking/confirm/{id}", name="booking_confirm", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function confirmAction(int $id): Response
    {
        $booking = $this->bookingService->getById($id);
        $rent = $this->bookingService->confirm(
            $booking,
            $this->getUser()
        );

        return $this->redirectToRoute('booking_confirm_success', ['id' => $rent->getId()]);
    }

    /**
     * @Route("/account/booking/confirm/{id}/success", name="booking_confirm_success", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function confirmSuccessAction(int $id)
    {
        $rent = $this->rentService->getById($id);

        return $this->render(
            'bookings/confirm-success.html.twig',
            [
                'rent' => $rent
            ]
        );
    }

}
