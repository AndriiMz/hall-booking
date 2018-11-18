<?php

namespace App\Repository;

use App\Entity\Wynajencie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Wynajencie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Wynajencie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Wynajencie[]    findAll()
 * @method Wynajencie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WynajencieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Wynajencie::class);
    }

//    /**
//     * @return Wynajencie[] Returns an array of Wynajencie objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Wynajencie
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
