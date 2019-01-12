<?php

namespace App\Controller;

use App\Service\Hall\PopularService;
use App\Service\PriceService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @var PopularService
     */
    private $popularService;
    /**
     * @var PriceService
     */
    private $priceService;

    public function __construct(
        PopularService $popularService,
        PriceService $priceService
    )
    {
        $this->popularService = $popularService;
        $this->priceService = $priceService;
    }

    public function indexAction()
    {
        $halls = $this->popularService->getAll();

        return $this->render(
            'index.html.twig',
            [
                'halls' => $halls,
                'priceService' => $this->priceService
            ]
        );
    }

    /**
     * @param string $view
     * @param array $parameters
     * @param Response|null $response
     * @return Response
     */
    protected function render(string $view, array $parameters = array(), Response $response = null): Response
    {
        return parent::render('index/' . $view, $parameters, $response);
    }
}
