<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RezerwacjaRepository")
 */
class Rezerwacja
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
    private $dataOd;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dataDo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $iloscOs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $komentarz;

    /**
     * @var Sala
     * @ORM\ManyToOne(targetEntity="Sala")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sala;

    /**
     * @var Klient
     * @ORM\ManyToOne(targetEntity="Klient")
     * @ORM\JoinColumn(nullable=true)
     */
    private $klient;

    /**
     * @return Klient
     */
    public function getKlient(): Klient
    {
        return $this->klient;
    }

    /**
     * @param Klient $klient
     */
    public function setKlient(Klient $klient): void
    {
        $this->klient = $klient;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataOd(): ?\DateTimeInterface
    {
        return $this->dataOd;
    }

    public function setDataOd(?\DateTimeInterface $dataOd): self
    {
        $this->dataOd = $dataOd;

        return $this;
    }

    public function getDataDo(): ?\DateTimeInterface
    {
        return $this->dataDo;
    }

    public function setDataDo(?\DateTimeInterface $dataDo): self
    {
        $this->dataDo = $dataDo;

        return $this;
    }

    public function getIloscOs(): ?int
    {
        return $this->iloscOs;
    }

    public function setIloscOs(?int $iloscOs): self
    {
        $this->iloscOs = $iloscOs;

        return $this;
    }

    public function getKomentarz(): ?string
    {
        return $this->komentarz;
    }

    public function setKomentarz(?string $komentarz): self
    {
        $this->komentarz = $komentarz;

        return $this;
    }

    /**
     * @return Sala
     */
    public function getSala(): Sala
    {
        return $this->sala;
    }

    /**
     * @param Sala $sala
     */
    public function setSala(Sala $sala): void
    {
        $this->sala = $sala;
    }
}
