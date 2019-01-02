<?php

namespace App\Controller;

use App\Entity\Opcja;
use App\Entity\Option;
use App\Enum\RequestTypeEnum;
use App\Service\HallService;
use App\Service\OptionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HallController extends Controller
{
    /**
     * @var HallService
     */
    private $service;
    /**
     * @var OptionService
     */
    private $optionService;

    public function __construct(HallService $service, OptionService $optionService)
    {
        $this->service = $service;
        $this->optionService = $optionService;
    }

    /**
     * @Route("/account/halls/list", name="halls_list")
     * @return Response
     */
    public function listAction(): Response
    {

        return $this->render(
            'halls/list.html.twig',
            ['halls' =>
                $this->service->getList(
                    $this->getUser()
                )
            ]
        );
    }

    /**
     * @Route("/account/hall/add", name="hall_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        if ($request->isMethod(RequestTypeEnum::POST)) {
            $this->service->addHall(
                $request,
                $this->getUser()
            );

            return $this->redirectToRoute('halls_list');
        }

        return $this->render(
            'halls/add.html.twig'
        );
    }

    /**
     * @Route("/account/hall/update/{id}", name="hall_update", requirements={ "id": "\d+" })
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function updateAction(Request $request, int $id): Response
    {
        if ($request->isMethod(RequestTypeEnum::POST)) {
            $this->service->updateHall(
                $request,
                $id
            );

            return $this->redirectToRoute('halls_list');
        }

        $hall = $this->service->getHall($id);
        $checkedOption = $hall->getOptions()->map(function(Option $option) {
            return $option->getId();
        });


        return $this->render(
            'halls/update.html.twig',
            [
                'hall' => $hall,
                'checkedOption' => $checkedOption,
                'options' => $this->optionService->getList()
            ]
        );
    }

    /**
     * @Route("/account/hall/remove/{id}", name="hall_remove", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function removeAction(int $id): Response {
        $this->service->removeHall($id);

        return $this->redirectToRoute('halls_list');
    }
}
