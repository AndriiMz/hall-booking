<?php

namespace App\Repository;

use App\Entity\Cena;
use App\Entity\Hall;
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
     * @param \DateTime $date
     * @param Hall $hall
     * @return null|Price
     */
    public function findByDate(Hall $hall, \DateTime $date): ?Price
    {
        return $this->createQueryBuilder('c')
            ->where('c.dataOd < :date')
            ->andWhere('c.dataDo > :date')
            ->setParameter('date', $date->format('Y-m-d'))
            ->andWhere('c.sala = :hall')
            ->setParameter('hall', $hall)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

//    /**
//     * @return Cena[] Returns an array of Cena objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cena
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
