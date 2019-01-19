<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Filter\BookingFilter;
use App\Service\BookingService;
use App\Service\RentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
    public function listAction(Request $request): Response
    {
        $bookingFilter = BookingFilter::fromRequest($request);

        $bookings = $this->bookingService->getList(null, $bookingFilter);

        return $this->render(
            'bookings/list.html.twig',
            [
                'bookings' => $bookings,
                'filter' => $bookingFilter,
            ]
        );
    }

    /**
     * @Route("/account/bookings/report/csv", name="bookings_report")
     * @param Request $request
     * @return Response
     */
    public function csvAction(Request $request): Response
    {
        $bookingFilter = BookingFilter::fromRequest($request);

        /** @var Booking[] $bookings */
        $bookings = $this->bookingService->getList(null, $bookingFilter);

        $list = array(
            array('Numer', 'Sala', 'Data od', 'Data do','Liczba osób','Komentarz','Imię klienta','Telefon klienta', 'E-mail klienta',),
        );

        foreach ($bookings as $booking) {
            $client = $booking->getClient();

            $list[] = [
                $booking->getId(),
                $booking->getHall()->getName(),
                $booking->getDateFrom()->format('Y-m-d H:i:s'),
                $booking->getDateTo()->format('Y-m-d H:i:s'),
                $booking->getPeoplesCount(),
                $booking->getComment(),
                $client->getFirstName(),
                $client->getPhone(),
                $client->getEmail()
            ];
        }

        $fp = fopen('php://output', 'w');
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }

        $response = new Response();
        $response->headers->set('Content-Encoding','UTF-8');
        $response->headers->set('Content-Type', 'text/csv;charset=UTF-8');
        $response->headers->set(
            'Content-Disposition',
            sprintf('attachment; filename="raport-%s.csv"' , (new \DateTime())->format('Y-m-d H:i:s'))
        );


        return $response;
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
