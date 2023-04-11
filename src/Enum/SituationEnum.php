<?php

namespace App\Enum;

enum SituationEnum: string
{
    case Salary = 'salary';
    case Student = 'student';
    case Unemployment = 'unemployment';
    case Other = 'other';
}
