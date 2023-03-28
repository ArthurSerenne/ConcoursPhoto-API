<?php

namespace App\Enum;

enum OrganizationTypeEnum: string
{
    case city = "ville/commune";
    case community = "communauté de communes";
    case department = "département";
    case region = "région";
    case office = "office de tourisme";
    case country = "pays";
    case private = "entreprise privée";
    case ong = "association/ONG";
    case other = "autre organisme";

    public static function getEnumChoices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[$case->value] = $case->name;
        }
        return $choices;
    }

    public function getBackedValue(): string
    {
        return $this->value;
    }

    public static function fromValue(string $value): ?BackedEnumValue
    {
        return self::match($value) ?? null;
    }
}
