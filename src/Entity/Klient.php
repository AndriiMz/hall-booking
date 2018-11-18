<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\KlientRepository")
 */
class Klient
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nazwa;

    /**
     * @ORM\Column(type="string", length=15)
     */
    private $telefon;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $miasto;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $adress;

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

    public function getTelefon(): ?string
    {
        return $this->telefon;
    }

    public function setTelefon(string $telefon): self
    {
        $this->telefon = $telefon;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }
}
