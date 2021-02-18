<?php

namespace App;

interface ItemInterface
{
    public function getISBNNumber():int;

    public function getTitle():string;
}