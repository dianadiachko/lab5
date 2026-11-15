<?php

namespace App\Exceptions;

use Exception;

class CategoryNotEmpty extends Exception
{
    public function __construct()
    {
        parent::__construct('Неможливо видалити категорію, оскільки вона містить товари.');
    }
}
