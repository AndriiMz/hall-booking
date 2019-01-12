<?php

namespace App\Repository;

use App\Entity\Price;
use App\Entity\Hall;
use App\Filter\CatalogFilter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Price|null find($id, $lockMode = null, $lockVersion = null)
 * @method Price|null findOneBy(array $criteria, array $orderBy = null)
 * @method Price[]    findAll()
 * @method Price[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Price::class);
    }

    /**
     * @param CatalogFilter|null $filter
     * @param Hall $hall
     * @return null|Price
     */
    public function findByFilter(Hall $hall, CatalogFilter $filter = null): ?Price
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->andWhere('c.hall = :hall')
            ->setParameter('hall', $hall);

        if (!$filter || (!$filter->dateFrom && !$filter->dateTo)) {
            $queryBuilder = $queryBuilder
                ->andWhere('c.dateFrom <= :date AND c.dateTo >= :date')
                ->setParameter('date', new \DateTime());
        }

        if ($filter) {
            $dateCondition = [];
            $dateParameters = [];

            if ($filter->dateFrom) {
                $dateCondition[] = 'c.dateFrom <= :dateFrom AND c.dateTo >= :dateFrom';
                $dateParameters['dateFrom'] = $filter->dateFrom;
            }

            if ($filter->dateTo) {
                $dateCondition[] = 'c.dateFrom <= :dateTo AND c.dateTo >= :dateTo';
                $dateParameters['dateTo'] = $filter->dateTo;
            }

            if (!empty($dateCondition) && !empty($dateParameters)) {
                $queryBuilder = $queryBuilder
                    ->andWhere(implode(' OR ', $dateCondition));

                foreach ($dateParameters as $key => $dateParameter) {
                    $queryBuilder = $queryBuilder
                        ->setParameter($key, $dateParameter);
                }
            }
        }


        return $queryBuilder
            ->getQuery()
            ->getOneOrNullResult();
    }
}
