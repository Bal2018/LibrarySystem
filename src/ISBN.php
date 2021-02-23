<?php

namespace App;

use App\IncorrectISBNFormat;
use App\IncorrectISBNZeros;

class ISBN
{
    protected int $ISBNNumber;

    /**
     * ISBN constructor.
     * @param $ISBNNumber
     * @throws \App\IncorrectISBNFormat
     * @throws \App\IncorrectISBNZeros
     */
    public function __construct($ISBNNumber)
    {
        if (!ctype_digit(strval($ISBNNumber))){
            throw new \InvalidArgumentException("ERROR : Incorrect ISBN Format - must be integer");
        }
        if (intval($ISBNNumber) == 0 ) {
            throw IncorrectISBNZeros::withISBNZeros($ISBNNumber);

        }
        if (strlen(strval($ISBNNumber)) !== 13 ) {
            throw IncorrectISBNFormat::withISBNFormat($ISBNNumber);
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

    /**
     * @param $ISBNNumber
     * @return bool
     */
    public function checkValidISBN($ISBNNumber): bool
    {
       return array_sum(str_split($ISBNNumber)) % 10 == 0;
    }
}