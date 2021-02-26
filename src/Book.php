<?php

namespace App;

class Book extends ItemBaseClass implements ItemInterface
{
    public function enterSynopsis() : string
    {
        // TODO: Implement enterSynopsis() method.
        return ("SYNOPSIS ENTERED ");
    }

    public function enterAuthorDetails() :string
    {
        // TODO: Implement enterAuthorDetails() method.

        return ("AuthorDetails");
    }
    public function enterCoverType() : bool
    {
        return true;
    }
}
