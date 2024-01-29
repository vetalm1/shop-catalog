<?php

namespace App\Support\Enums;

enum ContactPlaceType: string
{
    case Header = 'header';
    case Footer = 'footer';
    case ContactsPage = 'contacts_page';
    case ProductPage = 'product_page';

    public static function getSelectData(): array
    {
        return [
            self::Header->value => 'Шапка сайта',
            self::Footer->value => 'Подвал сайта',
            self::ContactsPage->value => 'Стр. контакты',
            self::ProductPage->value => 'Стр. товара',
        ];
    }
}
