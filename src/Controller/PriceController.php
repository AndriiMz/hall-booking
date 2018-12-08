<?php

namespace App\Controller;

use App\Enum\RequestTypeEnum;
use App\Service\HallService;
use App\Service\PriceService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PriceController extends Controller
{
    /**
     * @var PriceService
     */
    private $service;
    /**
     * @var HallService
     */
    private $hallService;

    public function __construct(PriceService $service, HallService $hallService)
    {
        $this->service = $service;
        $this->hallService = $hallService;
    }

    /**
     * @Route("/account/prices/list/{id}", name="prices_list", requirements={ "id": "\d+" })
     * @return Response
     */
    public function listAction(int $id): Response
    {
        return $this->render(
            'prices/list.html.twig',
            [
                'prices' => $this->service->getList($id),
                'hall' => $this->hallService->getHall($id)
            ]
        );
    }

    /**
     * @Route("/account/price/add/{id}", name="price_add", requirements={ "id": "\d+" })
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request, int $id): Response
    {
        $hall = $this->hallService->getHall($id);

        if ($request->isMethod(RequestTypeEnum::POST)) {

            $this->service->addPrice(
                $request,
                $hall
            );

            return $this->redirectToRoute('prices_list', ['id' => $hall->getId()]);
        }

        return $this->render(
            'prices/add.html.twig',
            [
                'id' => $id,
                'hall' => $hall
            ]
        );
    }


    /**
     * @Route("/account/price/remove/{hallId}/{id}", name="price_remove", requirements={ "id": "\d+", "hallId" : "\d+" })
     * @param int $hallId
     * @param int $id
     * @return Response
     */
    public function removeAction(int $hallId, int $id): Response {
        $this->service->removePrice($id);

        return $this->redirectToRoute('prices_list', ['id' => $hallId]);
    }
}
