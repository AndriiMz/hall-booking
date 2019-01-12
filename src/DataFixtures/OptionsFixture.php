<?php

namespace App\DataFixtures;

use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class OptionsFixture extends Fixture implements FixtureInterface
{
    public const OPTION_1_REF = 'OPTION_1_REF';
    public const OPTION_2_REF = 'OPTION_2_REF';
    public const OPTION_3_REF = 'OPTION_3_REF';
    public const OPTION_4_REF = 'OPTION_4_REF';
    public const OPTION_5_REF = 'OPTION_5_REF';

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->ensureOption(
            $manager,
            [
                'n' => 'Klimatyzacja',
                'd' => 'Klimatyzacja w sali',
                't' => self::OPTION_1_REF
            ]
        );

        $this->ensureOption(
            $manager,
            [
                'n' => 'Projektor',
                'd' => 'Projektor w sali',
                't' => self::OPTION_2_REF
            ]
        );

        $this->ensureOption(
            $manager,
            [
                'n' => 'Zestaw Głośnomówiący',
                'd' => 'Zestaw Głośnomówiący dla prowadzenia konferencji przez internet',
                't' => self::OPTION_3_REF
            ]
        );

        $this->ensureOption(
            $manager,
            [
                'n' => 'Telewizor',
                'd' => 'Telewizor',
                't' => self::OPTION_4_REF
            ]
        );

        $this->ensureOption(
            $manager,
            [
                'n' => 'Lodówka',
                'd' => 'Lodówka',
                't' => self::OPTION_5_REF
            ]
        );
    }

    public function ensureOption(ObjectManager $em, $data): void
    {
        $option = new Option();
        $option->setName($data['n']);
        $option->setDescription($data['d']);

        $em->persist($option);
        $this->setReference($data['t'], $option);
        $em->flush();
    }
}
