<?php

namespace App\Service;

use App\Entity\Hall;
use App\Filter\CatalogFilter;
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
     * @param CatalogFilter $catalogFilter
     * @return array
     */
    public function getAll(CatalogFilter $catalogFilter): array
    {
        return $this
            ->repo
            ->findByCatalogFilter(
                $catalogFilter
            );
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
