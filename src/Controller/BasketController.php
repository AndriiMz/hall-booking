<?php

namespace App\Controller;

use App\Service\BasketService;
use App\Service\PriceService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasketController extends Controller
{
    /**
     * @var BasketService
     */
    private $basketService;
    /**
     * @var PriceService
     */
    private $priceService;

    /**
     * BasketController constructor.
     * @param BasketService $basketService
     */
    public function __construct(BasketService $basketService, PriceService $priceService)
    {
        $this->basketService = $basketService;
        $this->priceService = $priceService;
    }

    /**
     * @Route("/basket/add", name="basket_add")
     * @param Request $request
     * @return Response
     */
    public function setAction(Request $request): Response
    {
        $id = $request->get('id');
        $this->basketService->set($id);

        return JsonResponse::create([
            'success' => true
        ]);
    }

    /**
     * @Route("/basket/remove", name="basket_remove")
     * @param Request $request
     * @return Response
     */
    public function removeAction(Request $request): Response
    {
        $id = $request->get('id');
        $this->basketService->remove($id);

        return JsonResponse::create([
            'success' => true
        ]);
    }

    /**
     * @Route("/basket", name="basket")
     * @return Response
     */
    public function indexAction(): Response
    {
        $items = $this->basketService->getAll();

        return $this->render(
            'basket/index.html.twig',
            [
                'halls' => $items,
                'priceService' => $this->priceService
            ]
        );
    }
}
