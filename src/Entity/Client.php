<?php

namespace App\Entity;

use App\Enum\UserRoleEnum;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Client extends User
{
    public function getRoles(): array
    {
        return [UserRoleEnum::CLIENT_ROLE];
    }

    public function getRole(): string
    {
        return UserRoleEnum::CLIENT_ROLE;
    }
}
