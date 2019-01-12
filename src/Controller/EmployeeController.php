<?php

namespace App\Controller;

use App\Enum\RequestTypeEnum;
use App\Service\EmployeeService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends Controller
{
    /**
     * @var EmployeeService
     */
    private $employeeService;

    public function __construct(EmployeeService $staffService)
    {
        $this->employeeService = $staffService;
    }

    /**
     * @Route("/account/employee/list", name="employee_list")
     * @return Response
     */
    public function listAction(): Response
    {

        return $this->render(
            'staff/list.html.twig',
            ['users' => $this->employeeService->getList()]
        );
    }

    /**
     * @Route("/account/employee/add", name="employee_add")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request): Response
    {
        if ($request->isMethod(RequestTypeEnum::POST)) {
            $this->employeeService->addUser($request);

            return $this->redirectToRoute('employee_list');
        }

        return $this->render(
            'staff/add.html.twig',
            ['user' => false]
        );
    }

    /**
     * @Route("/account/employee/edit/{id}", name="employee_edit", requirements={ "id": "\d+" })
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function editAction(Request $request, int $id): Response
    {
        $employee = $this->employeeService->getById($id);

        if ($request->isMethod(RequestTypeEnum::POST)) {
            $this->employeeService->updateUser($request, $employee);

            return $this->redirectToRoute('employee_list');
        }

        return $this->render(
            'staff/add.html.twig',
            ['user' => $employee]
        );
    }

    /**
     * @Route("/account/employee/remove/{id}", name="employee_remove", requirements={ "id": "\d+" })
     * @param int $id
     * @return Response
     */
    public function removeAction(int $id): Response {
        $this->employeeService->deleteUser($id);

        return $this->redirectToRoute('employee_list');
    }

}
