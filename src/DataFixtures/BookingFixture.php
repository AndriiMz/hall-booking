<?php

namespace App\DataFixtures;

use App\Entity\Booking;
use App\Entity\Client;
use App\Entity\Hall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class BookingFixture extends Fixture implements FixtureInterface, DependentFixtureInterface
{
    /**
     * @return array
     */
    public function getDependencies(): array
    {
        return array(
            UsersFixture::class,
            HallsFixture::class
        );
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager): void
    {
        $this->ensureBooking(
            $manager,
            [
                'h' => HallsFixture::HALL_3_REF,
                'u' => UsersFixture::CLIENT_1_REF,
                't' => new \DateTime('2019-01-02 10:00'),
                'f' => new \DateTime('2019-01-03 22:00'),
                'c' => 'Czekamy !!',
                'p' => 200
            ]
        );

        $this->ensureBooking(
            $manager,
            [
                'h' => HallsFixture::HALL_3_REF,
                'u' => UsersFixture::CLIENT_2_REF,
                't' => new \DateTime('2019-01-04 10:00'),
                'f' => new \DateTime('2019-01-05 22:00'),
                'c' => 'Urodziny szefa !!',
                'p' => 100
            ]
        );

        $this->ensureBooking(
            $manager,
            [
                'h' => HallsFixture::HALL_4_REF,
                'u' => UsersFixture::CLIENT_2_REF,
                't' => new \DateTime('2019-01-06 10:00'),
                'f' => new \DateTime('2019-01-07 22:00'),
                'c' => 'Urodziny księgowej !!',
                'p' => 120
            ]
        );

        $this->ensureBooking(
            $manager,
            [
                'h' => HallsFixture::HALL_5_REF,
                'u' => UsersFixture::CLIENT_1_REF,
                't' => new \DateTime('2019-01-06 10:00'),
                'f' => new \DateTime('2019-01-07 22:00'),
                'c' => 'Urodziny księgowej !!',
                'p' => 100
            ]
        );
    }

    /**
     * @param ObjectManager $em
     * @param $data
     */
    private function ensureBooking(ObjectManager $em, $data): void
    {
        /** @var Hall $hall */
        $hall = $this->getReference($data['h']);
        /** @var Client $user */
        $user = $this->getReference($data['u']);

        $booking = new Booking();
        $booking->setHall($hall);
        $booking->setClient($user);
        $booking->setDateTo($data['t']);
        $booking->setDateFrom($data['f']);
        $booking->setComment($data['c']);
        $booking->setPeoplesCount($data['p']);

        $em->persist($booking);
        $em->flush();
    }
}
