<?php

namespace App\Service;

use App\Entity\Employee;
use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Repository\HallRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EmployeeService
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * @var HallRepository $hallRepository
     */
    private $hallRepository;

    /**
     * StaffService constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @param HallRepository $hallRepository
     */
    public function __construct(
        UserRepository $userRepository,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->encoder = $encoder;
    }

    /**
     * @return User[]
     */
    public function getList(): array
    {
        return $this
            ->em
            ->getRepository(Employee::class)
            ->findAll();
    }

    /**
     * @param int $id
     * @return Employee
     */
    public function getById(int $id): Employee
    {
        return $this
            ->em
            ->getRepository(Employee::class)
            ->find($id);
    }

    /**
     * @param Request $request
     * @return Employee
     */
    public function addUser(Request $request): Employee
    {
        $user = new Employee();
        $user = $this->mapRequestToUser($request, $user);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param int $id
     * @return User
     */
    public function deleteUser(int $id): User
    {
        $user = $this->userRepository->find($id);
        $this->em->remove($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param Request $request
     * @param Employee $user
     * @return Employee
     */
    public function updateUser(Request $request, Employee $user): Employee
    {
        $user = $this->mapRequestToUser($request, $user);
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param Request $request
     * @param Employee $user
     * @return Employee
     */
    private function mapRequestToUser(
        Request $request,
        Employee $user
    ): Employee
    {
        $user->setFirstName($request->get('firstName'));
        $user->setLastName($request->get('lastName'));
        $user->setEmail($request->get('email'));
        $user->setUsername($request->get('username'));

        $password = $request->get('password');
        $user->setPlainPassword($password);
        $user->setPassword($this->encoder->encodePassword($user, $password));

        $user->setSalary($request->get('salary'));
        $user->setPesel($request->get('pesel'));
        $user->setBirthDate(
            new \DateTime($request->get('birthDate'))
        );

        $user->setCity($request->get('city'));
        $user->setAddress($request->get('address'));
        $user->setPhone($request->get('phone'));

        return $user;
    }

}
