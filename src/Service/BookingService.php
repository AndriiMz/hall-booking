<?php

namespace App\Service;

use App\Entity\Booking;
use App\Entity\Hall;
use App\Entity\User;
use App\Entity\Rent;
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
        $days = (int)$interval->format('d');
        $price = $this->priceService->getByDate($booking->getSala());

        if (null !== $price) {
            $rent->setAmount($days * $price->getWartosc());
        } else {
            $rent->setAmount($days);
        }

        $this->em->persist($rent);
        $this->em->flush();

        return $rent;
    }

    /**
     * @return array|Rent
     */
    public function getList(): array
    {
        $sqlQuery = 'SELECT 
            b.*
            FROM 
            booking b 
            LEFT JOIN booking r 
            ON r.rezewacja_id = b.id WHERE r.id IS NULL';

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
