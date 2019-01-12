<?php

namespace App\Service\Hall;

use App\Repository\HallRepository;

class PopularService
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
     * @return array
     */
    public function getAll(): array
    {
        $popularCount = 3;

        return $this->repo->findPopular($popularCount);
    }
}
