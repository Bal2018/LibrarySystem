<?php

namespace App;

class ExtraLongTitle extends \Exception
{
    public static function withLongTitle($title) :  self
    {
        return new self(\sprintf('ERROR : Extra long title entered - Title must be < 180 chars [%s]', $title));
    }
}
