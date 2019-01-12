<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\Rent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Rent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rent[]    findAll()
 * @method Rent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentRepository extends ServiceEntityRepository
{
    /**
     * RentRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Rent::class);
    }

    /**
     * @param Client $client
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findByClient(Client $client): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.booking', 'bkng')
            ->andWhere('bkng.client = :client')
            ->setParameter('client', $client)
            ->getQuery()
            ->getResult();
    }
}
