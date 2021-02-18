<?php

namespace App;

class ISBN
{
    protected int $ISBNNumber;

    /**
     * ISBN constructor.
     * @param $ISBNNumber
     */
    public function __construct($ISBNNumber)
    {
        if (!is_numeric($ISBNNumber)){

         throw new \InvalidArgumentException("ERROR ISBN must be a integer");
        }
        if (strlen(strval($ISBNNumber)) !== 13 ) {
            throw new \InvalidArgumentException("ERROR ISBN must be 13 digits");
        }
        $this->ISBNNumber= $ISBNNumber;
    }

    /**
     * @return int
     */
    public function getISBNNumber(): int
    {
        return $this->ISBNNumber;
    }
}