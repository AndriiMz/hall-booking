<?php

namespace App\Repository;

use App\Entity\Cena;
use App\Entity\Sala;
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

    /**
     * @param \DateTime $date
     * @param Sala $hall
     * @return null|Cena
     */
    public function findByDate(Sala $hall, \DateTime $date): ?Cena
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
