<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=100)
     */
    private $filePath;

    /**
     * @var Sala
     * @ORM\ManyToOne(targetEntity="Sala")
     * @ORM\JoinColumn()
     */
    private $hall;

    /**
     * @return Sala
     */
    public function getHall(): Sala
    {
        return $this->hall;
    }

    /**
     * @param Sala $hall
     */
    public function setHall(Sala $hall): void
    {
        $this->hall = $hall;
    }

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
     * @return mixed
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * @param mixed $filePath
     */
    public function setFilePath($filePath): void
    {
        $this->filePath = $filePath;
    }



}
