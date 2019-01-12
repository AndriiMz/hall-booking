<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Employee;
use App\Entity\User;
use App\Entity\Rent;
use App\Repository\RentRepository;

class RentService
{
    /**
     * @var RentRepository
     */
    private $repo;

    public function __construct(RentRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getList(User $user): array
    {
        if ($user instanceof Employee) {
            return $this->repo->findBy(['approvedBy' => $user]);
        }

        if ($user instanceof Client) {
            return $this->repo->findByClient($user);
        }

        return [];
    }



    /**
     * @param int $id
     * @return Rent|null
     */
    public function getById(int $id): ?Rent
    {
        return $this->repo->find($id);
    }

}
