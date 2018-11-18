<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var Pracownik
     * @ORM\ManyToOne(targetEntity="Pracownik")
     * @ORM\JoinColumn(nullable=true)
     */
    private $pracownik;

    /**
     * @ORM\ManyToMany(targetEntity="Opcja")
     * @ORM\JoinTable(name="opcja_sali",
     *      joinColumns={@ORM\JoinColumn(name="id_sali", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="id_opcji", referencedColumnName="id")}
     *      )
     * @var ArrayCollection
     */
    private $opcje;

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
     * @return Pracownik
     */
    public function getPracownik(): Pracownik
    {
        return $this->pracownik;
    }

    /**
     * @param Pracownik $pracownik
     * @return Sala
     */
    public function setPracownik(Pracownik $pracownik): self
    {
        $this->pracownik = $pracownik;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOpcje(): ArrayCollection
    {
        return $this->opcje;
    }

    /**
     * @param ArrayCollection $opcje
     */
    public function setOpcje(ArrayCollection $opcje): void
    {
        $this->opcje = $opcje;
    }
}
