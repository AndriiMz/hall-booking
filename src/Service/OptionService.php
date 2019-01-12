<?php

namespace App\Service;

use App\Entity\Option;
use App\Repository\OptionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class OptionService
{
    /**
     * @var OptionRepository
     */
    private $repo;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(OptionRepository $repo, EntityManagerInterface $em)
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
     * @param $id
     * @return Option|null
     */
    public function getById($id): ?Option
    {
        return $this->repo->find($id);
    }

    /**
     * @param Request $request
     * @return Option
     */
    public function addOption(Request $request)
    {
        $option = new Option();
        $option = $this->mapRequestToOption(
            $request,
            $option
        );

        $this->em->persist($option);
        $this->em->flush();

        return $option;
    }

    /**
     * @param Request $request
     * @param Option $option
     * @return Option
     */
    public function updateOption(Request $request, Option $option): Option
    {
        $option = $this->mapRequestToOption(
            $request,
            $option
        );

        $this->em->persist($option);
        $this->em->flush();

        return $option;
    }

    /**
     * @param int $id
     * @return Option|null
     */
    public function removeOption(int $id)
    {
        $option = $this->repo->find($id);

        $this->em->remove($option);
        $this->em->flush();

        return $option;
    }

    /**
     * @param Request $request
     * @param Option $option
     * @return Option
     */
    private function mapRequestToOption(Request $request, Option $option): Option
    {
        $option->setDescription($request->get('name'));
        $option->setName($request->get('description'));

        return $option;
    }
}
