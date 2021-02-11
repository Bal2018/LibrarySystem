<?php

namespace App;

interface ItemInterface
{
    public function getISBN():int;

    public function getTitle():string;
}