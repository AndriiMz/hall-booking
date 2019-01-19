<?php

namespace App\Repository;

use App\Entity\Hall;
use App\Filter\CatalogFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Hall|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hall|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hall[]    findAll()
 * @method Hall[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HallRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Hall::class);
    }

    /**
     * @return array
     */
    public function findPopular($count = 3): array
    {
        return $this->createQueryBuilder('h')
            ->addSelect('COUNT(h.id) AS HIDDEN counter')
            ->leftJoin('h.booking', 'b')
            ->groupBy('h.id')
            ->orderBy('counter', 'DESC')
            ->setMaxResults($count)
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param CatalogFilter $catalogFilter
     * @return array
     */
    public function findByCatalogFilter(CatalogFilter $catalogFilter): array
    {
        $sortMapping = [
            'price' => 'price.value',
            'area' => 'h.area'
        ];


        $queryBuilder = $this->createQueryBuilder('h');

        if ($catalogFilter->options && !empty($catalogFilter->options)) {
            $queryBuilder = $queryBuilder->leftJoin('h.options', 'opts')
                ->where('opts.id IN (:options)')
                ->setParameter(
                    'options',
                    array_values(
                        $catalogFilter->options
                    )
                );
        }


        $queryBuilder = $queryBuilder->leftJoin('h.prices', 'price');

        $dateCondition = [];
        $dateParameters = [];

        if ($catalogFilter->dateFrom) {
            $dateCondition[] = 'price.dateFrom <= :dateFrom AND price.dateTo >= :dateFrom';
            $dateParameters['dateFrom'] = $catalogFilter->dateFrom;
        }

        if ($catalogFilter->dateTo) {
            $dateCondition[] = 'price.dateFrom <= :dateTo AND price.dateTo >= :dateTo';
            $dateParameters['dateTo'] = $catalogFilter->dateTo;
        }

        if (!empty($dateCondition) && !empty($dateParameters)) {
            $queryBuilder = $queryBuilder
                ->andWhere(implode(' OR ', $dateCondition));

            foreach ($dateParameters as $key => $dateParameter) {
                $queryBuilder = $queryBuilder
                    ->setParameter($key, $dateParameter);
            }
        } else {
            $queryBuilder = $queryBuilder
                ->andWhere('price.dateFrom <= :date AND price.dateTo >= :date')
                ->setParameter('date', new \DateTime());
        }

        if ($catalogFilter->priceFrom) {
            $queryBuilder = $queryBuilder
                ->andWhere('price.value >= :priceFrom')
                ->setParameter('priceFrom', $catalogFilter->priceFrom);
        }

        if ($catalogFilter->priceTo) {
            $queryBuilder = $queryBuilder
                ->andWhere('price.value <= :priceTo')
                ->setParameter('priceTo', $catalogFilter->priceTo);
        }

        if (!$catalogFilter->priceFrom && !$catalogFilter->priceTo) {
            $queryBuilder = $queryBuilder
                ->orWhere('price.id IS NULL');
        }


        $sort = ['h.id', 'ASC'];

        if ($catalogFilter->sortRaw) {
            $sortArr = explode('.', $catalogFilter->sortRaw);

            $sort[0] = $sortMapping[$sortArr[1]];
            $sort[1] = strtoupper($sortArr[0]);
        }

        $queryBuilder = $queryBuilder->orderBy(
            $sort[0],
            $sort[1]
        );

        return $queryBuilder
            ->getQuery()
            ->getResult();
    }
}
