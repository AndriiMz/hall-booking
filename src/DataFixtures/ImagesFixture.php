<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ImagesFixture extends Fixture implements FixtureInterface, DependentFixtureInterface
{
    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return array(
            HallsFixture::class
        );
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->ensureImages(
            $manager,
            [
                'h' => HallsFixture::HALL_1_REF,
                'i' => [
                    '1.jpeg',
                    '2.jpg',
                    '3.jpg',
                    '7.jpg'
                ]
            ]
        );

        $this->ensureImages(
            $manager,
            [
                'h' => HallsFixture::HALL_2_REF,
                'i' => [
                    '3.jpg',
                    '4.jpg',
                    '5.jpg',
                    '6.jpg',
                    '7.jpg',
                    '8.jpg'
                ]
            ]
        );

        $this->ensureImages(
            $manager,
            [
                'h' => HallsFixture::HALL_3_REF,
                'i' => [
                    '7.jpg',
                    '8.jpg',
                    '9.jpg',
                    '10.jpeg'
                ]
            ]
        );

        $this->ensureImages(
            $manager,
            [
                'h' => HallsFixture::HALL_4_REF,
                'i' => [
                    '10.jpeg',
                    '11.jpeg',
                    '12.jpeg',
                    '13.jpeg'
                ]
            ]
        );

        $this->ensureImages(
            $manager,
            [
                'h' => HallsFixture::HALL_5_REF,
                'i' => [
                    '14.jpeg',
                    '15.jpeg',
                    '1.jpeg',
                    '10.jpeg'
                ]
            ]
        );

    }

    /**
     * @param ObjectManager $em
     * @param $data
     */
    public function ensureImages(ObjectManager $em, $data): void
    {
        /** @var Hall $hall */
        $hall = $this->getReference($data['h']);

        foreach ($data['i'] as $img) {
            $image = new Image();
            $image->setFilePath($img);
            $image->setHall($hall);

            $em->persist($image);
        }

        $em->flush();
    }
}
