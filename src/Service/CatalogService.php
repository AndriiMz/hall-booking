<?php

namespace App\Service;

use App\Entity\Sala;
use App\Repository\SalaRepository;

class CatalogService
{
    /**
     * @var SalaRepository
     */
    private $repo;

    public function __construct(SalaRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return Sala[]
     */
    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    /**
     * @param $id
     * @return Sala
     */
    public function getItem($id): Sala
    {
        return $this->repo->find($id);
    }
}
