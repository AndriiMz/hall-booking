<?php
namespace App\DataFixtures;

use App\Entity\Administrator;
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
        $administrator = new Administrator();
        $administrator->setUsername('admin');
        $password = 1234;
        $administrator->setPlainPassword($password);
        $administrator->setPassword($this->encoder->encodePassword($administrator, $password));
        $administrator->setEmail('test@admin.lcl');
        $administrator->setFirstName('Admin');
        $administrator->setCity('Wroc');
        $administrator->setAddress('ul Prusa');
        $administrator->setPhone('733913212');

        $manager->persist($administrator);
        $manager->flush();
    }
}
