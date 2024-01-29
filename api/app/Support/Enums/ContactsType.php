<?php

namespace App\Support\Enums;

enum ContactsType: string
{
    case PHONE = 'phone';
    case EMAIL = 'email';
    case ADDRESS = 'address';
    case LINK = 'link';

    public static function getSelectData(): array
    {
        return [
            self::PHONE->value => 'Телефон',
            self::EMAIL->value => 'email',
            self::ADDRESS->value => 'Адрес',
            self::LINK->value => 'Ссылка',
        ];
    }
}
