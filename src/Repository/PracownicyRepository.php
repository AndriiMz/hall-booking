<?php

namespace App\Repository;

use App\Entity\Pracownik;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Pracownik|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pracownik|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pracownik[]    findAll()
 * @method Pracownik[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PracownicyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Pracownik::class);
    }

//    /**
//     * @return Pracownik[] Returns an array of Pracownik objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pracownik
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
