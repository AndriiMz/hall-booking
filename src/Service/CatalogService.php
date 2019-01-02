<?php

namespace App\Service;

use App\Entity\Hall;
use App\Repository\HallRepository;

class CatalogService
{
    /**
     * @var HallRepository
     */
    private $repo;

    public function __construct(HallRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return Hall[]
     */
    public function getAll(): array
    {
        return $this->repo->findAll();
    }

    /**
     * @param $id
     * @return Hall
     */
    public function getItem($id): Hall
    {
        return $this->repo->find($id);
    }
}
