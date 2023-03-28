<?php

namespace App\Enum;

enum SituationEnum: string
{
    case salary = 'Salarié';
    case boss = 'Patron';
    case other = 'Autre';
}
