<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use App\Entity\Price;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class HallPriceFixture extends Fixture implements FixtureInterface, DependentFixtureInterface
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
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->ensurePrice($manager,
            [
                'h' => HallsFixture::HALL_1_REF,
                'e' => [
                    [
                        'f' => new \DateTime('2019-01-01'),
                        't' => new \DateTime('2019-01-05'),
                        'v' => 50
                    ],
                    [
                        'f' => new \DateTime('2019-01-06'),
                        't' => new \DateTime('2019-01-31'),
                        'v' => 30
                    ],
                    [
                        'f' => new \DateTime('2019-02-01'),
                        't' => new \DateTime('2019-02-28'),
                        'v' => 25
                    ],
                ]
            ]
        );

        $this->ensurePrice($manager,
            [
                'h' => HallsFixture::HALL_2_REF,
                'e' => [
                    [
                        'f' => new \DateTime('2019-01-01'),
                        't' => new \DateTime('2019-01-10'),
                        'v' => 55
                    ],
                    [
                        'f' => new \DateTime('2019-01-11'),
                        't' => new \DateTime('2019-02-05'),
                        'v' => 40
                    ],
                    [
                        'f' => new \DateTime('2019-02-06'),
                        't' => new \DateTime('2019-03-30'),
                        'v' => 45
                    ],
                ]
            ]
        );

        $this->ensurePrice($manager,
            [
                'h' => HallsFixture::HALL_3_REF,
                'e' => [
                    [
                        'f' => new \DateTime('2019-01-01'),
                        't' => new \DateTime('2019-01-15'),
                        'v' => 55
                    ],
                    [
                        'f' => new \DateTime('2019-01-16'),
                        't' => new \DateTime('2019-02-28'),
                        'v' => 40
                    ]
                ]
            ]
        );

        $this->ensurePrice($manager,
            [
                'h' => HallsFixture::HALL_4_REF,
                'e' => [
                    [
                        'f' => new \DateTime('2019-01-01'),
                        't' => new \DateTime('2019-03-30'),
                        'v' => 30
                    ]
                ]
            ]
        );
    }

    /**
     * @param ObjectManager $em
     */
    public function ensurePrice(ObjectManager $em, $data): void
    {
        /** @var Hall $hall */
        $hall = $this->getReference($data['h']);

        foreach ($data['e'] as $entry) {
            $price = new Price();
            $price->setDateFrom($entry['f']);
            $price->setDateTo($entry['t']);
            $price->setValue($entry['v']);

            $price->setHall($hall);

            $em->persist($price);
        }

        $em->flush();
    }
}
