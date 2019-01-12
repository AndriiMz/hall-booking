<?php

namespace App\Service;

use App\Entity\Hall;
use App\Filter\CatalogFilter;
use App\Repository\PriceRepository;
use App\Entity\Price;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PriceService
{
    /**
     * HallService constructor.
     * @param PriceRepository $repo
     * @param EntityManagerInterface $em
     */
    public function __construct(PriceRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @param CatalogFilter|null $filter
     * @param Hall $hall
     * @return Price|null
     */
    public function getByDate($hall, $filter = null): ?Price
    {
        return $this->repo->findByFilter($hall, $filter);
    }

    /**
     * @param $hallId
     * @return Price[]
     */
    public function getList($hallId): array
    {
        return $this->repo->findBy(['hall' => $hallId]);
    }

    /**
     * @param Hall $hall
     * @return array|Price[]
     */
    public function getByHall(Hall $hall): array
    {
        return $this->repo->findBy(['hall' => $hall]);
    }

    /**
     * @param Request $request
     * @param Hall $hall
     * @return Price
     */
    public function addPrice(Request $request, Hall $hall): Price
    {
        $price = new Price();

        $price->setHall($hall);
        $price->setValue($request->get('value'));
        $price->setDateTo(
            new \DateTime($request->get('dateTo'))
        );
        $price->setDateFrom(
            new \DateTime($request->get('dateFrom'))
        );

        $this->em->persist($price);
        $this->em->flush();

        return $price;
    }

    /**
     * @param $id
     * @return Price|null
     */
    public function removePrice($id): ?Price
    {
        $price = $this->repo->find($id);

        $this->em->remove($price);
        $this->em->flush();

        return $price;
    }
}
