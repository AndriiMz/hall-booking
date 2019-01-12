<?php

namespace App\Service;

use App\Repository\HallRepository;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class BasketService
{
    private const HALL_SESSION_KEY = 'basketHalls';
    /**
     * @var Session
     */
    private $session;
    /**
     * @var HallRepository
     */
    private $repo;

    public function __construct(SessionInterface $session, HallRepository $repo)
    {
        $this->session = $session;
        $this->repo = $repo;
    }

    /**
     * @param $id
     */
    public function set($id): void
    {
        $basketItems = $this->session->get(self::HALL_SESSION_KEY);
        if (!$basketItems) {
            $basketItems = [];
        }
        $basketItems[] = $id;

        $this->session->set(self::HALL_SESSION_KEY, $basketItems);
    }

    /**
     * @param $id
     */
    public function remove($id): void
    {
        $basketItems = $this->session->get(self::HALL_SESSION_KEY);
        if ($basketItems) {
           $basketItems = array_filter(
               $basketItems,
               function ($item) use ($id) {
                   return $item !== $id;
               }
           );

           $this->session->set(self::HALL_SESSION_KEY, $basketItems);
        }
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $basketItems = $this->session->get(self::HALL_SESSION_KEY);
        $items = [];
        if ($basketItems) {
            $items = $this->repo->findBy(['id' => $basketItems]);
        }

        return $items;
    }

    /**
     * @return array
     */
    public function getIndexes(): array
    {
        $basketItems = $this->session->get(self::HALL_SESSION_KEY);

        if (!$basketItems) {
            $basketItems = [];
        } else {
            $basketItems = array_map(
                function($item) {
                    return (int)$item;
                },
                $basketItems
            );
        }

        return $basketItems;
    }
}
