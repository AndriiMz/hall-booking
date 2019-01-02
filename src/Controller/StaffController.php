<?php

namespace App\Controller;

use App\Enum\RequestTypeEnum;
use App\Service\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StaffController extends Controller
{
    /**
     * @var EmployeeService
     */
    private $staffService;

    public function __construct(EmployeeService $staffService)
    {
        $this->staffService = $staffService;
    }

    /**
     * @Route("/account/staff/list", name="staff_list")
     * @return Response
     */
    public function listAction(): Response
    {

        return $this->render(
            'staff/list.html.twig',
            ['users' => $this->staffService->getList()]
        );
    }

    /**
     * @Route("/account/staff/add", name="staff_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        if ($request->isMethod(RequestTypeEnum::POST)) {
            $this->staffService->addUser($request);

            return $this->redirectToRoute('staff_list');
        }

        return $this->render(
            'staff/add.html.twig'
        );
    }

    /**
     * @Route("/account/staff/remove/{id}", name="staff_remove", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function removeAction(int $id): Response {
        $this->staffService->deleteUser($id);

        return $this->redirectToRoute('staff_list');
    }

}
