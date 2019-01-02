<?php

namespace App\Service;

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
        return $this->repo->findBy(['approvedBy' => $user]);
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
