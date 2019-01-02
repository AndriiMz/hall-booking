<?php

namespace App\Entity;

use App\Enum\UserRoleEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Employee extends User
{
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $pesel;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $salary;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $lastName;

    public function getRoles(): array
    {
        return [UserRoleEnum::EMPLOYEE_ROLE];
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPesel()
    {
        return $this->pesel;
    }

    /**
     * @param mixed $pesel
     */
    public function setPesel($pesel): void
    {
        $this->pesel = $pesel;
    }

    /**
     * @return int
     */
    public function getSalary(): int
    {
        return $this->salary;
    }

    /**
     * @param int $salary
     */
    public function setSalary(int $salary): void
    {
        $this->salary = $salary;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate(\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    public function getRole(): string
    {
        return UserRoleEnum::EMPLOYEE_ROLE;
    }
}
