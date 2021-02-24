<?php

namespace App;


class ISBN
{
    protected int $ISBNNumber;
    protected array $AllBooks =[
        array (
            "ISBN" => 9780199535569,
            "title" =>"Pride and Prejudice"),
        array (
            "ISBN"=>9781526603180,
            "title"=>"Space Detectives"),
        array (
            "ISBN"=>9781471182617 ,
            "title"=>"The Littlest Yak"),
        array (
            "ISBN" =>9780670913503,
            "title"=>"Hairy Maclary from Donaldson's Dairy - Hairy Maclary and Friends"),
        array (
            "ISBN" =>9781509804788 ,
            "title"=>"A Squash and a Squeeze")
        ];

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
        $ISBNLength = strlen($ISBNNumber);
        if ($ISBNLength < 12 or $ISBNLength > 13) {
            throw new Exception('Invalid ISBN-13 format.');
        }

        //Calculate check digit
        $checkdigit = 0;
        for ($i = 0; $i < 12; $i += 2) {
            $checkdigit += 1 * substr($ISBNNumber, $i, 1);
            $checkdigit += 3 * substr($ISBNNumber, $i+1, 1);
        }

        $checkdigit = 10 - $checkdigit % 10;
        return ($checkdigit == substr($ISBNNumber,-1));

      // return array_sum(str_split($ISBNNumber)) % 10 == 0;
    }

    /**
     * @param $ISBNNumber
     * @return bool
     */
    public function getBookUsingISBN($NNumber): bool
    {
       return (in_array($NNumber, array_column($this->AllBooks,'ISBN')));
  //      return (in_array($NNumber, $this->AllBooks));
    }
}