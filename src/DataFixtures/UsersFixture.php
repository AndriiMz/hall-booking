<?php
namespace App\DataFixtures;

use App\Entity\Administrator;
use App\Entity\Client;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixture extends Fixture implements FixtureInterface
{
    public const EMPLOYEE_1_REF = 'EMPLOYEE_1_REF';
    public const EMPLOYEE_2_REF = 'EMPLOYEE_2_REF';

    public const CLIENT_1_REF = 'CLIENT_1_REF';
    public const CLIENT_2_REF = 'CLIENT_2_REF';

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }


    public function load(ObjectManager $manager)
    {
        $this->ensureAdmin($manager);
        $this->ensureEmployee($manager);
        $this->ensureClient($manager);
    }

    /**
     * @param ObjectManager $manager
     */
    private function ensureAdmin(ObjectManager $manager): void
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

    /**
     * @param ObjectManager $manager
     */
    private function ensureEmployee(ObjectManager $manager): void
    {
        $password = 1234;

        $employee = new Employee();
        $employee->setPhone('734813212');
        $employee->setEmail('test@mail.ru');
        $employee->setFirstName('Jan');
        $employee->setLastName('Kowalski');
        $employee->setUsername('j.kowalski');
        $employee->setPlainPassword($password);
        $employee->setPassword($this->encoder->encodePassword($employee, $password));
        $employee->setPesel(90090515836);
        $employee->setAddress('ul Sienkiewicza');
        $employee->setCity('Wroclaw');
        $employee->setSalary(5000);
        $employee->setBirthDate(new \DateTime('1997-12-15'));

        $manager->persist($employee);
        $manager->flush();
        $this->setReference(self::EMPLOYEE_1_REF, $employee);



        $employee = new Employee();
        $employee->setPhone('734813215');
        $employee->setEmail('a.wybranowski@gmail.com');
        $employee->setFirstName('Adam');
        $employee->setLastName('Wybranowski');
        $employee->setUsername('a.wybranowski');
        $employee->setPlainPassword($password);
        $employee->setPassword($this->encoder->encodePassword($employee, $password));
        $employee->setPesel(90090515837);
        $employee->setAddress('ul Sienkiewicza');
        $employee->setCity('Wroclaw');
        $employee->setSalary(4000);
        $employee->setBirthDate(new \DateTime('1995-04-28'));

        $manager->persist($employee);
        $manager->flush();
        $this->setReference(self::EMPLOYEE_2_REF, $employee);

    }

    /**
     * @param ObjectManager $manager
     */
    private function ensureClient(ObjectManager $manager): void {
        $password = 1234;

        $client = new Client();
        $client->setUsername('piotrek94');
        $client->setPlainPassword($password);
        $client->setPassword($this->encoder->encodePassword($client, $password));
        $client->setEmail('piotrek94@gmail.com');
        $client->setFirstName('Piotr');
        $client->setCity('Wroclaw');
        $client->setAddress('ul Bema 3');
        $client->setPhone('913212733');

        $manager->persist($client);
        $manager->flush();
        $this->setReference(self::CLIENT_1_REF, $client);


        $client = new Client();
        $client->setUsername('lukasz91');
        $client->setPlainPassword($password);
        $client->setPassword($this->encoder->encodePassword($client, $password));
        $client->setEmail('lukasz91@gmail.com');
        $client->setFirstName('Lukasz');
        $client->setCity('Wroclaw');
        $client->setAddress('ul Kolejowa 40');
        $client->setPhone('913212456');

        $manager->persist($client);
        $manager->flush();
        $this->setReference(self::CLIENT_2_REF, $client);

    }
}
