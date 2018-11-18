<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PracownicyRepository")
 */
class Pracownik
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $login;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $passwrd;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nazwisko;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $imie;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataUr;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $telefon;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $miasto;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adres;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pesel;

    /**
     * @ORM\Column(type="integer")
     */
    private $pensja;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPasswrd(): ?string
    {
        return $this->passwrd;
    }

    public function setPasswrd(string $passwrd): self
    {
        $this->passwrd = $passwrd;

        return $this;
    }

    public function getNazwisko(): ?string
    {
        return $this->nazwisko;
    }

    public function setNazwisko(string $nazwisko): self
    {
        $this->nazwisko = $nazwisko;

        return $this;
    }

    public function getImie(): ?string
    {
        return $this->imie;
    }

    public function setImie(string $imie): self
    {
        $this->imie = $imie;

        return $this;
    }

    public function getDataUr(): ?\DateTimeInterface
    {
        return $this->dataUr;
    }

    public function setDataUr(?\DateTimeInterface $dataUr): self
    {
        $this->dataUr = $dataUr;

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

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMiasto(): ?string
    {
        return $this->miasto;
    }

    public function setMiasto(?string $miasto): self
    {
        $this->miasto = $miasto;

        return $this;
    }

    public function getAdres(): ?string
    {
        return $this->adres;
    }

    public function setAdres(string $adres): self
    {
        $this->adres = $adres;

        return $this;
    }

    public function getPesel(): ?string
    {
        return $this->pesel;
    }

    public function setPesel(string $pesel): self
    {
        $this->pesel = $pesel;

        return $this;
    }

    public function getPensja(): ?int
    {
        return $this->pensja;
    }

    public function setPensja(int $pensja): self
    {
        $this->pensja = $pensja;

        return $this;
    }
}
