<?php

namespace App\Helpers;

class UserConstant
{
    const ACCESS_LOGIN = 20;
    const UNACCESS_LOGIN = 10;

    static function getListAccessLogin()
    {
        return [
            self::ACCESS_LOGIN => [
                'value' => self::ACCESS_LOGIN,
                'text' => 'Được phép đăng nhập'
            ],
            self::UNACCESS_LOGIN => [
                'value' => self::UNACCESS_LOGIN,
                'text' => 'Không được phép đăng nhập'
            ]
        ];
    }


}
