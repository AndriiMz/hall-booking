<?php

namespace App\Service;

use App\Entity\Administrator;
use App\Entity\Employee;
use App\Entity\Hall;
use App\Entity\User;
use App\Repository\OptionRepository;
use App\Repository\HallRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class HallService
{
    /**
     * @var HallRepository
     */
    private $repo;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var OptionRepository
     */
    private $optionsRepo;

    /**
     * HallService constructor.
     * @param HallRepository $repo
     * @param OptionRepository $optionsRepo
     * @param EntityManagerInterface $em
     */
    public function __construct(HallRepository $repo, OptionRepository $optionsRepo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
        $this->optionsRepo = $optionsRepo;
    }

    /**
     * @param User $user
     * @return array
     */
    public function getList(User $user): array
    {
        if ($user instanceof Employee) {
            return $this->repo->findBy(
                ['employee' => $user]
            );
        }

        if ($user instanceof Administrator) {
            return $this->repo->findAll();
        }

        return [];
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Hall
     */
    public function addHall(Request $request, User $user)
    {
        $hall = new Hall();
        $hall->setName($request->get('name'));
        $hall->setCity($request->get('city'));
        $hall->setAddress($request->get('address'));
        $hall->setArea($request->get('area'));
        $hall->setEmployee($user);

        $this->em->persist($hall);
        $this->em->flush();

        return $hall;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Hall
     */
    public function updateHall(Request $request, int $id)
    {
        /** @var Hall $hall */
        $hall = $this->repo->find($id);

        $hall->setName($request->get('name'));
        $hall->setCity($request->get('city'));
        $hall->setAddress($request->get('address'));
        $hall->setArea($request->get('area'));
        $options = $request->get('options');
        if (\is_array($options)) {
            $options = array_map(function($item) { return (int)$item; }, $options);
            $options = $this->optionsRepo->findBy(['id' => $options]);
            $hall->setOptions($options);
        } else {
            $hall->setOptions([]);
        }

        $this->em->persist($hall);
        $this->em->flush();

        return $hall;
    }

    /**
     * @param $id
     * @return Hall
     */
    public function getHall($id): Hall
    {
        return $this->repo->find($id);
    }

    /**
     * @param $id
     * @return Hall|null
     */
    public function removeHall($id)
    {
        $hall = $this->repo->find($id);

        $this->em->remove($hall);
        $this->em->flush();

        return $hall;
    }
}
