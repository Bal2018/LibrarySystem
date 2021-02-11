<?php

declare(strict_types=1);

namespace App;

class ItemBaseClass
{
    protected int $ISBN;
    protected string $title;
    /**
     * ItemBaseClass constructor.
     * @param $ISBN
     * @param $title
     */
    public function __construct(int $ISBN,  string $title)
    {
        $this->ISBN = $ISBN;
        $this->title = $title;
    }
    public function getISBN():int
    {
        return $this->ISBN;
    }
    public function getTitle():string
    {
        return $this->title;
    }
}