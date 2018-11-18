<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\WynajencieRepository")
 */
class Wynajencie
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
    private $suma;

    /**
     * @var Pracownik
     * @ORM\OneToOne(targetEntity="Rezerwacja")
     * @ORM\JoinColumn(nullable=true)
     */
    private $rezewacja;

    /**
     * @var Pracownik
     * @ORM\ManyToOne(targetEntity="Pracownik")
     * @ORM\JoinColumn(nullable=true)
     */
    private $zatwierdzonaPrzez;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuma(): ?int
    {
        return $this->suma;
    }

    public function setSuma(?int $suma): self
    {
        $this->suma = $suma;

        return $this;
    }

    /**
     * @return Pracownik
     */
    public function getRezewacja(): Pracownik
    {
        return $this->rezewacja;
    }

    /**
     * @param Pracownik $rezewacja
     */
    public function setRezewacja(Pracownik $rezewacja): void
    {
        $this->rezewacja = $rezewacja;
    }

    /**
     * @return Pracownik
     */
    public function getZatwierdzonaPrzez(): Pracownik
    {
        return $this->zatwierdzonaPrzez;
    }

    /**
     * @param Pracownik $zatwierdzonaPrzez
     */
    public function setZatwierdzonaPrzez(Pracownik $zatwierdzonaPrzez): void
    {
        $this->zatwierdzonaPrzez = $zatwierdzonaPrzez;
    }
}
