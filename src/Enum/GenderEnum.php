<?php

namespace App\Enum;

enum GenderEnum: string
{
    case male = 'Homme';
    case female = 'Femme';
    case other = 'Autre';
}
