<?php

namespace App\Service;

use App\Entity\Opcja;
use App\Entity\Sala;
use App\Repository\OpcjaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class OptionService
{
    /**
     * @var OpcjaRepository
     */
    private $repo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(OpcjaRepository $repo, EntityManagerInterface $em)
    {
        $this->repo = $repo;
        $this->em = $em;
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->repo->findAll();
    }

    /**
     * @param Request $request
     * @return Opcja
     */
    public function addOption(Request $request)
    {
        $option = new Opcja();
        $option->setNazwa($request->get('name'));
        $option->setOpis($request->get('description'));

        $this->em->persist($option);
        $this->em->flush();

        return $option;
    }

    /**
     * @param int $id
     * @return Opcja|null
     */
    public function removeOption(int $id)
    {
        $option = $this->repo->find($id);

        $this->em->remove($option);
        $this->em->flush();

        return $option;
    }
}
