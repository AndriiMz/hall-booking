<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CenaRepository")
 */
class Cena
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataDo;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataOd;

    /**
     * @ORM\Column(type="integer")
     */
    private $wartosc;

    /**
     * @var Sala
     * @ORM\ManyToOne(targetEntity="Sala")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sala;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDataDo(): ?\DateTimeInterface
    {
        return $this->dataDo;
    }

    public function setDataDo(\DateTimeInterface $dataDo): self
    {
        $this->dataDo = $dataDo;

        return $this;
    }

    public function getDataOd(): ?\DateTimeInterface
    {
        return $this->dataOd;
    }

    public function setDataOd(\DateTimeInterface $dataOd): self
    {
        $this->dataOd = $dataOd;

        return $this;
    }

    public function getWartosc(): ?int
    {
        return $this->wartosc;
    }

    public function setWartosc(int $wartosc): self
    {
        $this->wartosc = $wartosc;

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
