<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HallRepository")
 */
class Hall
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $nameH;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\Column(type="integer")
     */
    private $area;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $employee;

    /**
     * @ORM\ManyToMany(targetEntity="Option")
     * @ORM\JoinTable(name="hall_option",
     *      joinColumns={@ORM\JoinColumn(name="hall_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="option_id", referencedColumnName="id")}
     *      )
     * @var Collection
     */
    private $options;

    /**
     * @ORM\OneToMany(targetEntity="Price", mappedBy="hall", fetch="EXTRA_LAZY")
     * @var Collection $prices
     */
    private $prices;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="hall", fetch="EXTRA_LAZY")
     * @var Collection $images
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="Booking", mappedBy="hall", fetch="EXTRA_LAZY")
     * @var Collection $booking
     */
    private $booking;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->nameH;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->nameH = $name;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $area
     */
    public function setArea($area): void
    {
        $this->area = $area;
    }

    /**
     * @return User
     */
    public function getEmployee(): User
    {
        return $this->employee;
    }

    /**
     * @param User $employee
     */
    public function setEmployee(User $employee): void
    {
        $this->employee = $employee;
    }

    /**
     * @return Collection
     */
    public function getOptions(): Collection
    {
        return $this->options;
    }

    /**
     * @param Collection|array $options
     */
    public function setOptions($options): void
    {
        $this->options = $options;
    }

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Collection $images
     */
    public function setImages(Collection $images): void
    {
        $this->images = $images;
    }

    /**
     * @return Collection
     */
    public function getBooking(): Collection
    {
        return $this->booking;
    }

    /**
     * @param Collection $booking
     */
    public function setBooking(Collection $booking): void
    {
        $this->booking = $booking;
    }

    /**
     * @return Collection
     */
    public function getPrices(): Collection
    {
        return $this->prices;
    }

    /**
     * @param Collection $prices
     */
    public function setPrices(Collection $prices): void
    {
        $this->prices = $prices;
    }
}
