<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SalaRepository")
 */
class Sala
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
    private $nazwa;

    /**
     * @ORM\Column(type="string")
     */
    private $miasto;

    /**
     * @ORM\Column(type="string")
     */
    private $adresa;

    /**
     * @ORM\Column(type="integer")
     */
    private $powierzchnia;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pracownik;

    /**
     * @ORM\ManyToMany(targetEntity="Opcja")
     * @ORM\JoinTable(name="opcja_sali",
     *      joinColumns={@ORM\JoinColumn(name="id_sali", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_opcji", referencedColumnName="id")}
     *      )
     * @var Collection
     */
    private $opcje;

    /**
     * @ORM\OneToMany(targetEntity="Image", mappedBy="hall", fetch="EXTRA_LAZY")
     * @var Collection $images
     */
    private $images;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazwa(): ?string
    {
        return $this->nazwa;
    }

    public function setNazwa(string $nazwa): self
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    public function getMiasto(): ?string
    {
        return $this->miasto;
    }

    public function setMiasto(string $miasto): self
    {
        $this->miasto = $miasto;

        return $this;
    }

    public function getAdresa(): ?string
    {
        return $this->adresa;
    }

    public function setAdresa(string $adresa): self
    {
        $this->adresa = $adresa;

        return $this;
    }

    public function getPowierzchnia(): ?int
    {
        return $this->powierzchnia;
    }

    public function setPowierzchnia(?int $powierzchnia): self
    {
        $this->powierzchnia = $powierzchnia;

        return $this;
    }

    /**
     * @return User
     */
    public function getPracownik(): User
    {
        return $this->pracownik;
    }

    /**
     * @param User $pracownik
     * @return Sala
     */
    public function setPracownik(User $pracownik): self
    {
        $this->pracownik = $pracownik;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getOpcje(): Collection
    {
        return $this->opcje;
    }

    /**
     * @param $opcje
     */
    public function setOpcje($opcje): void
    {
        $this->opcje = $opcje;
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
}
