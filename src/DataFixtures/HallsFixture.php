<?php

namespace App\DataFixtures;

use App\Entity\Employee;
use App\Entity\Hall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class HallsFixture extends Fixture implements FixtureInterface, DependentFixtureInterface
{
    public const HALL_1_REF = 'HALL_1_REF';
    public const HALL_2_REF = 'HALL_2_REF';
    public const HALL_3_REF = 'HALL_3_REF';
    public const HALL_4_REF = 'HALL_4_REF';
    public const HALL_5_REF = 'HALL_5_REF';

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->ensureHall($manager,
            [
                'c' => 'Wroclaw',
                'a' => 'ul Bema 10',
                'n' => 'Sala konfrencyjna na Bema, Hotel Eleon',
                'ar' => 300,
                'e' => UsersFixture::EMPLOYEE_1_REF,
                't' => self::HALL_1_REF
            ]
        );

        $this->ensureHall($manager,
            [
                'c' => 'Wroclaw',
                'a' => 'ul Wittiga 15',
                'n' => 'Sala imprezowa akademika T-15',
                'ar' => 110,
                'e' => UsersFixture::EMPLOYEE_2_REF,
                't' => self::HALL_2_REF
            ]
        );

        $this->ensureHall($manager,
            [
                'c' => 'Wroclaw',
                'a' => 'ul Dworcowa 10',
                'n' => 'Piękna salka dla uroczystosci',
                'ar' => 150,
                'e' => UsersFixture::EMPLOYEE_1_REF,
                't' => self::HALL_3_REF
            ]
        );

        $this->ensureHall($manager,
            [
                'c' => 'Wroclaw',
                'a' => 'ul Stalowa 30',
                'n' => 'Morine conference hall, sala konferecyjna',
                'ar' => 160,
                'e' => UsersFixture::EMPLOYEE_2_REF,
                't' => self::HALL_4_REF
            ]
        );

        $this->ensureHall($manager,
            [
                'c' => 'Wroclaw',
                'a' => 'ul Lotnicza 12',
                'n' => 'Sala konferencyjna na lotniczej',
                'ar' => 160,
                'e' => UsersFixture::EMPLOYEE_2_REF,
                't' => self::HALL_5_REF
            ]
        );
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return array(
            UsersFixture::class,
        );
    }

    /**
     * @param ObjectManager $em
     */
    private function ensureHall(ObjectManager $em, $data): void
    {
        $hall = new Hall();
        $hall->setCity($data['c']);
        $hall->setAddress($data['a']);
        $hall->setName($data['n']);
        $hall->setArea($data['ar']);
        /** @var Employee $employee */
        $employee = $this->getReference($data['e']);
        $hall->setEmployee($employee);

        $em->persist($hall);
        $this->setReference($data['t'], $hall);
        $em->flush();
    }
}
