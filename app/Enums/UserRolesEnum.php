<?php

namespace App\Enums;

enum UserRolesEnum: int
{
    case admin = 1;
    case user = 2;
    case manager = 3;
}
