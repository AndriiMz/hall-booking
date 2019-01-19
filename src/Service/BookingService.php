<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Client;
use App\Entity\Hall;
use App\Entity\User;
use App\Entity\Rent;
use App\Filter\BookingFilter;
use App\Filter\CatalogFilter;
use App\Repository\BookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Symfony\Component\HttpFoundation\Request;

class BookingService
{
    /**
     * @var BookingRepository
     */
    private $repo;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var PriceService
     */
    private $priceService;

    /**
     * BookingService constructor.
     * @param BookingRepository $repo
     * @param PriceService $priceService
     * @param EntityManagerInterface $em
     */
    public function __construct(
        BookingRepository $repo,
        PriceService $priceService,
        EntityManagerInterface $em
    )
    {
        $this->repo = $repo;
        $this->priceService = $priceService;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Hall $hall
     * @return Booking
     */
    public function add(
        Request $request,
        User $user,
        Hall $hall
    ): Booking
    {
        $booking = new Booking();

        $booking->setDateFrom(
            new \DateTime(
                $request->get('dateFrom')
            )
        );
        $booking->setDateTo(
            new \DateTime(
                $request->get('dateTo')
            )
        );
        $booking->setPeoplesCount($request->get('peopleCount'));
        $booking->setComment($request->get('comment'));
        $booking->setClient($user);
        $booking->setHall($hall);

        $this->em->persist($booking);
        $this->em->flush();

        return $booking;
    }

    /**
     * @param Booking $booking
     * @param User $user
     * @return Rent|null
     */
    public function confirm(Booking $booking, User $user): ?Rent
    {
        $rent = new Rent();
        $rent->setBooking($booking);
        $rent->setApprovedBy($user);

        $dateTo = $booking->getDateFrom();
        $dateFrom = $booking->getDateTo();

        $interval = $dateFrom->diff($dateTo);
        $hours = $interval->h;
        $hours = $hours + ($interval->days * 24);

        $filter = new CatalogFilter();
        $filter->dateFrom = $dateFrom;
        $filter->dateTo = $dateTo;

        $price = $this->priceService->getByDate($booking->getHall(), $filter);

        if (null !== $price) {
            $rent->setAmount($hours * $price->getValue());
        } else {
            $rent->setAmount($hours);
        }

        $this->em->persist($rent);
        $this->em->flush();

        return $rent;
    }

    /**
     * @param Client|null $client
     * @return array|Rent
     */
    public function getList(Client $client = null, BookingFilter $filter = null): array
    {
        $userCondition = '';
        $userJoin = '';

        if ($client) {
            $userJoin = 'LEFT JOIN client c ON b.client_id = c.id ';
            $userCondition = sprintf('AND c.id = %s', $client->getId());
        }

        $dateCondition = '';
        if ($filter && ($filter->dateFrom || $filter->dateTo)) {
            $dateConds = [];
            if ($filter->dateFrom) {
                $dateConds[] = sprintf('b.date_from <= "%s"', $filter->dateFrom->format('Y-m-d'));
            }
            if ($filter->dateTo) {
                $dateConds[] = sprintf('b.date_to >= "%s"', $filter->dateTo->format('Y-m-d'));
            }

            $dateCondition = ' AND ' . implode(' AND ', $dateConds);
        }

        $sqlQuery = sprintf('SELECT 
            b.*
            FROM 
            booking b 
            LEFT JOIN rent r 
            ON r.booking_id = b.id 
            %s WHERE r.id IS NULL %s %s',
            $userJoin,
            $userCondition,
            $dateCondition
        );

        $rsm = new ResultSetMappingBuilder($this->em);
        $rsm->addRootEntityFromClassMetadata(Booking::class, 'b');

        $query = $this->em->createNativeQuery($sqlQuery, $rsm);

        return $query->getResult();
    }

    /**
     * @param $id
     * @return Booking|null
     */
    public function getById($id): ?Booking
    {
        return $this->repo->find($id);
    }
}
