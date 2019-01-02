<?php

namespace App\Entity;

use App\Enum\UserRoleEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Administrator extends User
{
    public function getRoles(): array
    {
        return [UserRoleEnum::ADMIN_ROLE];
    }

    public function getRole(): string
    {
        return UserRoleEnum::ADMIN_ROLE;
    }
}
