<?php

namespace App\Service;

use App\Entity\Sala;
use App\Repository\CenaRepository;
use App\Entity\Cena;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PriceService
{
    /**
     * HallService constructor.
     * @param CenaRepository $repo
     * @param EntityManagerInterface $em
     */
    public function __construct(CenaRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @param \DateTime|null $date
     * @param Sala $hall
     * @return Cena|null
     */
    public function getByDate($hall, \DateTime $date = null): ?Cena
    {
        if (null === $date) {
            $date = new \DateTime();
        }

        return $this->repo->findByDate($hall, $date);
    }

    /**
     * @param $hallId
     * @return Cena[]
     */
    public function getList($hallId): array
    {
        return $this->repo->findBy(['sala' => $hallId]);
    }

    /**
     * @param Sala $hall
     * @return array|Cena[]
     */
    public function getByHall(Sala $hall): array
    {
        return $this->repo->findBy(['sala' => $hall]);
    }

    /**
     * @param Request $request
     * @param Sala $hall
     * @return Cena
     */
    public function addPrice(Request $request, Sala $hall): Cena
    {
        $price = new Cena();

        $price->setSala($hall);
        $price->setWartosc($request->get('value'));
        $price->setDataDo(
            new \DateTime($request->get('dateTo'))
        );
        $price->setDataOd(
            new \DateTime($request->get('dateFrom'))
        );

        $this->em->persist($price);
        $this->em->flush();

        return $price;
    }

    /**
     * @param $id
     * @return Cena|null
     */
    public function removePrice($id): ?Cena
    {
        $price = $this->repo->find($id);

        $this->em->remove($price);
        $this->em->flush();

        return $price;
    }
}
