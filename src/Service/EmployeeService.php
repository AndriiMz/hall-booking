<?php

namespace App\Service;

use App\Entity\Employee;
use App\Entity\User;
use App\Enum\UserRoleEnum;
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
     * StaffService constructor.
     * @param UserRepository $userRepository
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
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
        return $this->userRepository->findBy(['type' => Employee::class]);
    }

    /**
     * @param Request $request
     * @return User
     */
    public function addUser(Request $request): User
    {
        $user = new Employee();
        $user->setFirstName($request->get('firstName'));
        $user->setLastName($request->get('lastName'));
        $user->setEmail($request->get('email'));
        $user->setUsername($request->get('username'));

        $password = $request->get('password');
        $user->setPlainPassword($password);
        $user->setPassword($this->encoder->encodePassword($user, $password));


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

    public function updateUser()
    {

    }

}
