<?php

namespace App\Service;

use App\Entity\Sala;
use App\Entity\User;
use App\Repository\OpcjaRepository;
use App\Repository\SalaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class HallService
{
    /**
     * @var SalaRepository
     */
    private $repo;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var OpcjaRepository
     */
    private $optionsRepo;

    /**
     * HallService constructor.
     * @param SalaRepository $repo
     * @param OpcjaRepository $optionsRepo
     * @param EntityManagerInterface $em
     */
    public function __construct(SalaRepository $repo, OpcjaRepository $optionsRepo, EntityManagerInterface $em)
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
        return $this->repo->findBy(['pracownik' => $user]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Sala
     */
    public function addHall(Request $request, User $user)
    {
        $hall = new Sala();
        $hall->setNazwa($request->get('name'));
        $hall->setMiasto($request->get('city'));
        $hall->setAdresa($request->get('address'));
        $hall->setPowierzchnia($request->get('area'));
        $hall->setPracownik($user);

        $this->em->persist($hall);
        $this->em->flush();

        return $hall;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return Sala
     */
    public function updateHall(Request $request, int $id)
    {
        /** @var Sala $hall */
        $hall = $this->repo->find($id);

        $hall->setNazwa($request->get('name'));
        $hall->setMiasto($request->get('city'));
        $hall->setAdresa($request->get('address'));
        $hall->setPowierzchnia($request->get('area'));
        $options = $request->get('options');
        if (\is_array($options)) {
            $options = array_map(function($item) { return (int)$item; }, $options);
            $options = $this->optionsRepo->findBy(['id' => $options]);
            $hall->setOpcje($options);
        } else {
            $hall->setOpcje([]);
        }

        $this->em->persist($hall);
        $this->em->flush();

        return $hall;
    }

    /**
     * @param $id
     * @return Sala
     */
    public function getHall($id): Sala
    {
        return $this->repo->find($id);
    }

    /**
     * @param $id
     * @return Sala|null
     */
    public function removeHall($id)
    {
        $hall = $this->repo->find($id);

        $this->em->remove($hall);
        $this->em->flush();

        return $hall;
    }
}
