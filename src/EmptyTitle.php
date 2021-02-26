<?php


namespace App;

class EmptyTitle extends \Exception
{
    public static function titleIsEmpty() : self
    {
        return new self(\sprintf('ERROR : Incorrect Title - must not be empty'));
    }
}
