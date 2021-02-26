<?php

namespace App;

class ExtraTagsInTitle extends \Exception
{
    public static function withExtraTags($title) :  self
    {
        return new self(\sprintf('ERROR : Extra information entered with title - [%s]', $title));
    }
}
