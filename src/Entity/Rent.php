<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RentRepository")
 */
class Rent
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var Booking
     * @ORM\OneToOne(targetEntity="Booking")
     * @ORM\JoinColumn(nullable=true)
     */
    private $booking;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $approvedBy;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @return Booking
     */
    public function getBooking(): Booking
    {
        return $this->booking;
    }

    /**
     * @param Booking $booking
     */
    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
    }

    /**
     * @return User
     */
    public function getApprovedBy(): User
    {
        return $this->approvedBy;
    }

    /**
     * @param User $approvedBy
     */
    public function setApprovedBy(User $approvedBy): void
    {
        $this->approvedBy = $approvedBy;
    }
}
