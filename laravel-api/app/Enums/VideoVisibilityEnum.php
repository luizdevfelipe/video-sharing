<?php

namespace App\Enums;

enum VideoVisibilityEnum: int
{
    case PUBLIC = 1;
    case PROTECTED = 2;
    case PRIVATE = 3;
}