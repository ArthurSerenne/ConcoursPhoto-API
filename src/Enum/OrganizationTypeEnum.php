<?php

namespace App\Enum;

enum OrganizationTypeEnum: string
{
    case City = 'city';
    case Community = 'community';
    case Department = 'department';
    case Region = 'region';
    case Office = 'office';
    case Country = 'country';
    case Private = 'private';
    case Ong = 'ong';
    case Other = 'other';
}
