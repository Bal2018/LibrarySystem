<?php

namespace App;

class Title
{
    private string $title;

    /**
     * Title constructor.
     * @param $title
     */
    public function __construct($title)
    {
        if ((strlen($title) > 0) || strlen(trim($title) == 0)){

         throw new \InvalidArgumentException("ERROR : Title must not be empty ");
        }

        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}