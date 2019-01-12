<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Entity\Option;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class HallOptionsFixture extends Fixture implements FixtureInterface, DependentFixtureInterface
{
    public function getDependencies()
    {
        return array(
            HallsFixture::class,
            OptionsFixture::class
        );
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->linkOption(
            $manager,
            HallsFixture::HALL_1_REF,
            [
                OptionsFixture::OPTION_1_REF,
                OptionsFixture::OPTION_2_REF,
                OptionsFixture::OPTION_3_REF,
                OptionsFixture::OPTION_4_REF
            ]
        );

        $this->linkOption(
            $manager,
            HallsFixture::HALL_2_REF,
            [
                OptionsFixture::OPTION_3_REF,
                OptionsFixture::OPTION_4_REF,
                OptionsFixture::OPTION_5_REF
            ]
        );


        $this->linkOption(
            $manager,
            HallsFixture::HALL_3_REF,
            [
                OptionsFixture::OPTION_2_REF
            ]
        );


//        $this->linkOption(
//            $manager,
//            HallsFixture::HALL_4_REF,
//            [
//
//            ]
//        );

        $this->linkOption(
            $manager,
            HallsFixture::HALL_5_REF,
            [
                OptionsFixture::OPTION_1_REF,
                OptionsFixture::OPTION_3_REF,
            ]
        );
    }

    /**
     * @param ObjectManager $em
     * @param string $hallRef
     * @param array $optionRefs
     */
    public function linkOption(
        ObjectManager $em,
        string $hallRef,
        array $optionRefs
    ): void
    {
        /** @var null|Hall $hall */
        $hall = $this->getReference($hallRef);
        if (null === $hall) {
            return;
        }

        /** @var Option[] $options */
        $options = array_map(function ($ref) {
            return $this->getReference($ref);
        }, $optionRefs);

        $hall->setOptions($options);

        $em->persist($hall);
        $em->flush();
    }
}
