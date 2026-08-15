<?php

namespace App;

use App\Concerns\EnumTrait;
use BenSampo\Enum\Enum;
use BenSampo\Enum\Attributes\Description;

final class RoleType extends Enum
{
    use EnumTrait;

    const UNKNOWN = 'unknown';

    #[Description('User')]
    const USER = 'user';

    #[Description('Editor')]
    const EDITOR = 'editor';

    #[Description('Admin')]
    const ADMIN = 'admin';

    #[Description('Administrator')]
    const ADMINISTRATOR = 'administrator';

    #[Description('Supervisor')]
    const SUPERVISOR = 'supervisor';

    #[Description('Teknisi')]
    const TEKNISI = 'teknisi';

    #[Description('Developer')]
    const DEVELOPER = 'developer';

    public static function getDescription($value): string
    {
        if ($value === self::UNKNOWN) {
            return '';
        }

        return parent::getDescription($value);
    }
}
