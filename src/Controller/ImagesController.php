<?php

namespace App\Controller;

use App\Enum\RequestTypeEnum;
use App\Service\HallService;
use App\Service\ImagesService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImagesController extends Controller
{
    /**
     * @var ImagesService
     */
    private $service;
    /**
     * @var HallService
     */
    private $hallService;

    public function __construct(ImagesService $service, HallService $hallService)
    {
        $this->service = $service;
        $this->hallService = $hallService;
    }

    /**
     * @Route("/account/images/list/{id}", name="images_list", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function listAction(int $id): Response
    {
        return $this->render(
            'images/list.html.twig',
            [
                'images' => $this->service->getList($id),
                'hall' => $this->hallService->getHall($id)
            ]
        );
    }

    /**
     * @Route("/account/image/add/{id}", name="image_add", requirements={ "id": "\d+" })
     * @param int $id
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request, int $id): Response
    {
        $hall = $this->hallService->getHall($id);

        if ($request->isMethod(RequestTypeEnum::POST)) {

            $this->service->addImage(
                $request,
                $hall,
                $this->getParameter('images_directory')
            );

            return $this->redirectToRoute('images_list', ['id' => $hall->getId()]);
        }

        return $this->render(
            'images/add.html.twig',
            [
                'id' => $id,
                'hall' => $hall
            ]
        );
    }


    /**
     * @Route("/account/image/remove/{hallId}/{id}", name="image_remove", requirements={ "id": "\d+", "hallId" : "\d+" })
     * @param int $hallId
     * @param int $id
     * @return Response
     */
    public function removeAction(int $hallId, int $id): Response {
        $this->service->removeImage($id);

        return $this->redirectToRoute('images_list', ['id' => $hallId]);
    }
}
