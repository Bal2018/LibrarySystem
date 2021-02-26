<?php


namespace App;

class IncorrectISBNZeros extends \Exception
{
    public static function withISBNZeros($isbnNo) :  self
    {
        return new self(\sprintf('ERROR : Incorrect ISBN Format for [%s] - must not be just zeros', $isbnNo));
    }
}
