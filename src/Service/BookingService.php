<?php

namespace App\Service;

use App\Entity\Rezerwacja;
use App\Entity\Sala;
use App\Entity\User;
use App\Entity\Wynajencie;
use App\Repository\RezerwacjaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class BookingService
{
    /**
     * @var RezerwacjaRepository
     */
    private $repo;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * BookingService constructor.
     * @param RezerwacjaRepository $repo
     * @param EntityManagerInterface $em
     */
    public function __construct(
        RezerwacjaRepository $repo,
        EntityManagerInterface $em
    )
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @param User $user
     * @param Sala $hall
     * @return Rezerwacja
     */
    public function add(
        Request $request,
        User $user,
        Sala $hall
    ): Rezerwacja
    {
        $booking = new Rezerwacja();

        $booking->setDataOd(
            new \DateTime(
                $request->get('dateFrom')
            )
        );
        $booking->setDataDo(
            new \DateTime(
                $request->get('dateTo')
            )
        );
        $booking->setIloscOs($request->get('peopleCount'));
        $booking->setKomentarz($request->get('comment'));
        $booking->setKlient($user);
        $booking->setSala($hall);

        $this->em->persist($booking);
        $this->em->flush();

        return $booking;
    }

    /**
     * @return array|Wynajencie
     */
    public function getList(): array
    {
        return $this->repo->findBy(['rental' => null]);
    }

    /**
     * @param $id
     * @return Rezerwacja|null
     */
    public function getById($id): ?Rezerwacja
    {
        return $this->repo->find($id);
    }
}
