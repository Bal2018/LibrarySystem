<?php

declare(strict_types=1);

namespace App;

class ItemBaseClass
{
    protected ISBN $ISBN;
    protected string $title;
    /**
     * ItemBaseClass constructor.
     * @param $ISBN
     * @param $title
     */
    public function __construct(ISBN $ISBN,  string $title)
    {
        $this->ISBN = $ISBN;
        $this->title = $title;
    }

    public function getISBNNumber():int
    {
        return $this->ISBN->getISBNNumber();
    }

    public function getTitle():string
    {
        return $this->title;
    }
}