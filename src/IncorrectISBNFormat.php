<?php

namespace App;

class IncorrectISBNFormat extends \Exception
{
    public static function withISBNFormat($isbnNo) :  self
    {
        return new self(\sprintf('ERROR : Incorrect ISBN Format for [%s] - must be 13 digits long', $isbnNo));
    }
}
