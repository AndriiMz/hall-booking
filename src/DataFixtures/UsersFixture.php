<?php
namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\UserRoleEnum;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixture extends Fixture implements FixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $userClient = new User();
        $userClient->setUsername('admin');
        $password = 1234;
        $userClient->setPlainPassword($password);
        $userClient->setPassword($this->encoder->encodePassword($userClient, $password));
        $userClient->setEmail('test@admin.lcl');
        $userClient->setRole(UserRoleEnum::ADMIN_ROLE);
        $userClient->setFirstName('Admin');
        $userClient->setLastName('Adminowski');

        $manager->persist($userClient);
        $manager->flush();
    }
}
