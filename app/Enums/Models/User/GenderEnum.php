<?php

namespace App\Enums\Models\User;

enum GenderEnum: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case UNKNOWN = 'unknown';
}
