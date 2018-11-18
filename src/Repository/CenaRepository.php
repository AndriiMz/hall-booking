<?php

namespace App\Repository;

use App\Entity\Cena;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Cena|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cena|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cena[]    findAll()
 * @method Cena[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CenaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Cena::class);
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
