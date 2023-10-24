<?php

namespace App\Exceptions;

use JetBrains\PhpStorm\Pure;

class PositionNotFoundException extends \Exception
{
    #[Pure] public function __construct(string $address)
    {
        $message = 'Не найдено результатов для адреса ' . $address;

        parent::__construct($message);
    }
}
