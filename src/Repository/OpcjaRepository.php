<?php

namespace App\Repository;

use App\Entity\Opcja;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Opcja|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opcja|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opcja[]    findAll()
 * @method Opcja[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpcjaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Opcja::class);
    }

//    /**
//     * @return Opcja[] Returns an array of Opcja objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Opcja
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
