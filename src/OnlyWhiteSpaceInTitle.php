<?php

namespace App;

class OnlyWhiteSpaceInTitle extends \Exception
{
    public static function withWhiteSpaces() :  self
    {
        return new self(\sprintf('ERROR : Title must not be just spaces'));
    }
}
