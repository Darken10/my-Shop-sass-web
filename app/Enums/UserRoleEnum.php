<?php

namespace App\Enums;

enum UserRoleEnum: string
{
    case SUPER_ADMIN = 'super admin';
    case OWNER = 'owner';
    case MANAGER = 'manager';
    case CASHIER = 'cashier';
    case STOREKEEPER = 'storekeeper';
    case ACCOUNTANT = 'accountant';

    /**
     * Return an array of role string values.
     *
     * @return array<int,string>
     */
    public static function values(): array
    {
        return array_map(fn (UserRoleEnum $r) => $r->value, self::cases());
    }
}
