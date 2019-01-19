<?php

namespace App\Service;

use App\Entity\Client;
use App\Entity\Employee;
use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationService
{
    private $em;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function fromRequest(Request $request): User
    {

        $username = $request->get('username');
        $user = $this->userRepository->findBy(
            ['username' => $username]
        );

        if (null !== $user) {
            throw new \Exception('Użytkownik z takim loginem już istnieje');
        }

        $user = new Client();
        $user->setFirstName($request->get('firstName'));
        $user->setEmail($request->get('email'));
        $user->setUsername($request->get('username'));
        $user->setPhone($request->get('phone'));

        $password = $request->get('password');
        $user->setPlainPassword($password);
        $user->setPassword($this->encoder->encodePassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param User $user
     * @param Request $request
     * @return User
     */
    public function updateFromRequest(User $user, Request $request): User
    {
        $user->setFirstName(
            $request->get('firstName')
        );

        $user->setEmail(
            $request->get('mail')
        );
        $user->setPhone(
            $request->get('phone')
        );
        $user->setUsername(
            $request->get('username')
        );

        if ($user instanceof Employee) {
            $user->setLastName(
                $request->get('lastName')
            );

            $user->setPesel(
                $request->get('pesel')
            );

        }

        $password = $request->get('password');
        if (strlen($password) > 0) {
            $user->setPlainPassword($password);
            $user->setPassword($this->encoder->encodePassword($user, $password));
        }

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function fromBookingRequest(Request $request): User
    {
        $username = $request->get('username');
        $user = $this->userRepository->findBy(
            ['username' => $username]
        );

        if (null !== $user) {
            throw new \Exception('Użytkownik z takim loginem już istnieje');
        }

        $user = new Client();
        $user->setFirstName(
            $request->get('firstName')
        );
        $user->setEmail(
            $request->get('mail')
        );
        $user->setPhone(
            $request->get('phone')
        );

        $user->setUsername(
            $username
        );

        $password = $request->get('password');
        $user->setPlainPassword($password);
        $user->setPassword($this->encoder->encodePassword($user, $password));


        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
