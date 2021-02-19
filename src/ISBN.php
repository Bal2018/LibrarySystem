<?php

namespace App;

use phpDocumentor\Reflection\Types\Boolean;
use App\IncorrectISBNFormat;
class ISBN
{
    protected int $ISBNNumber;

    /**
     * ISBN constructor.
     * @param $ISBNNumber
     * @throws \App\IncorrectISBNFormat
     */
    public function __construct($ISBNNumber)
    {
        if (!is_numeric($ISBNNumber)){
            echo "ERRRRROOOORR Not numeric -- all of it ";
         throw new \InvalidArgumentException("ERROR : ISBN must be a integer");
        }
        if (strlen(strval($ISBNNumber)) !== 13 ) {
            throw new IncorrectISBNFormat("ERROR : Incorrect ISBN Format - must be 13 digits long");
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