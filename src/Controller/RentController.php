<?php

namespace App\Controller;

use App\Entity\Rent;
use App\Service\RentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/account/rent/report/csv", name="rent_report")
     * @param Request $request
     * @return Response
     */
    public function csvAction(Request $request): Response
    {
        /** @var Rent[] $rents */
        $rents = $this->rentService->getList(
            $this->getUser()
        );

        $list = array(
            array('Numer', 'Sala', 'Data od', 'Data do', 'Liczba osób', 'Komentarz', 'Imię klienta', 'Telefon klienta', 'E-mail klienta', 'Suma'),
        );

        foreach ($rents as $rent) {
            $booking = $rent->getBooking();
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
                $client->getEmail(),
                $rent->getAmount()
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
}
