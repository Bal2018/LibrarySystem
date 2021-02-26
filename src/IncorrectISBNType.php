<?php

namespace App;

class IncorrectISBNType extends \Exception
{
    public static function withISBNType($isbnNo) :  self
    {
        return new self(\sprintf('ERROR : Incorrect ISBN Format for [%s] - must be integer', $isbnNo));
    }
}
