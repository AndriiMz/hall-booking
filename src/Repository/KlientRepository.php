<?php

namespace App\Repository;

use App\Entity\Klient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Klient|null find($id, $lockMode = null, $lockVersion = null)
 * @method Klient|null findOneBy(array $criteria, array $orderBy = null)
 * @method Klient[]    findAll()
 * @method Klient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KlientRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Klient::class);
    }

//    /**
//     * @return Klient[] Returns an array of Klient objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Klient
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
