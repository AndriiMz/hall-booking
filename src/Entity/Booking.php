<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookingRepository")
 */
class Booking
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateFrom;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateTo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $peoplesCount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $comment;

    /**
     * @var Hall
     * @ORM\ManyToOne(targetEntity="Hall")
     * @ORM\JoinColumn(nullable=true)
     */
    private $hall;

    /**
     * @var Client
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="Rent", mappedBy="booking", fetch="EXTRA_LAZY", cascade={"remove"})
     * @var Collection $rents
     */
    private $rents;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom(): \DateTime
    {
        return $this->dateFrom;
    }

    /**
     * @param mixed $dateFrom
     */
    public function setDateFrom($dateFrom): void
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo(): \DateTime
    {
        return $this->dateTo;
    }

    /**
     * @param mixed $dateTo
     */
    public function setDateTo($dateTo): void
    {
        $this->dateTo = $dateTo;
    }

    /**
     * @return mixed
     */
    public function getPeoplesCount()
    {
        return $this->peoplesCount;
    }

    /**
     * @param mixed $peoplesCount
     */
    public function setPeoplesCount($peoplesCount): void
    {
        $this->peoplesCount = $peoplesCount;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return Hall
     */
    public function getHall(): Hall
    {
        return $this->hall;
    }

    /**
     * @param Hall $hall
     */
    public function setHall(Hall $hall): void
    {
        $this->hall = $hall;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param User $client
     */
    public function setClient(User $client): void
    {
        $this->client = $client;
    }
}
