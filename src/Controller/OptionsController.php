<?php

namespace App\Controller;

use App\Enum\RequestTypeEnum;
use App\Service\OptionService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OptionsController extends Controller
{
    /**
     * @var OptionService
     */
    private $service;

    public function __construct(OptionService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/account/options/list", name="options_list")
     * @return Response
     */
    public function listAction(): Response
    {

        return $this->render(
            'options/list.html.twig',
            ['options' =>
                $this->service->getList()
            ]
        );
    }

    /**
     * @Route("/account/option/add", name="option_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        if ($request->isMethod(RequestTypeEnum::POST)) {
            $this->service->addOption(
                $request
            );

            return $this->redirectToRoute('options_list');
        }

        return $this->render(
            'options/add.html.twig'
        );
    }

    /**
     * @Route("/account/option/remove/{id}", name="option_remove", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function removeAction(int $id): Response {
        $this->service->removeOption($id);

        return $this->redirectToRoute('options_list');
    }
}
