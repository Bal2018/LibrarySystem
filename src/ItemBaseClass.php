<?php

declare(strict_types=1);

namespace App;

use Exception;

class ItemBaseClass
{
    protected int $ISBNNumber;
    protected string $title;

    /**
     *  Constructor.
     * @param int $ISBNNumber
     * @param string $title
     * @throws IncorrectISBNFormat
     * @throws IncorrectISBNZeros
     * @throws EmptyTitle
     * @throws ExtraTagsInTitle
     * @throws ExtraLongTitle
     * @throws OnlyWhiteSpaceInTitle
     */
    public function __construct(int $ISBNNumber, string $title)
    {
        if (!ctype_digit(strval($ISBNNumber))) {
            throw new \InvalidArgumentException("ERROR : Incorrect ISBN Format - must be integer");
        }
        if (intval($ISBNNumber) == 0) {
            throw IncorrectISBNZeros::withISBNZeros($ISBNNumber);
        }
        if (strlen(strval($ISBNNumber)) !== 13) {
            throw IncorrectISBNFormat::withISBNFormat($ISBNNumber);
        }
        $this->ISBNNumber= $ISBNNumber;

        if (empty($title)) {
            throw EmptyTitle::titleIsEmpty();
        }
        if ($title != strip_tags($title)) {
            throw ExtraTagsInTitle::withExtraTags($title);
        }
        if (strlen($title) > 180) {
            throw ExtraLongTitle::withLongTitle($title);
        }
        if (ctype_space($title)) {
            throw OnlyWhiteSpaceInTitle::withWhiteSpaces();
        }
        $this->title = $title;
    }

    public function getISBNNumber():int
    {
        return $this->ISBNNumber;
    }

    public function getTitle():string
    {
        return $this->title;
    }

    /**
     * @param $ISBNNumber
     * @return bool
     * @throws Exception
     */
    public static function checkValidISBN($ISBNNumber): bool
    {
        $ISBNLength = strlen(strval($ISBNNumber));
        if ($ISBNLength < 12 or $ISBNLength > 13) {
            throw new Exception('Invalid ISBN-13 format.');
        }

        //Calculate check digit
        $checkDigit = 0;
        for ($i = 0; $i < 12; $i += 2) {
            $checkDigit += 1 * substr(strval($ISBNNumber), $i, 1);
            $checkDigit += 3 * substr(strval($ISBNNumber), $i+1, 1);
        }

        $checkDigit =  $checkDigit % 10;
        if ($checkDigit != 0) {
            $checkDigit = 10 - $checkDigit;
        }
        return ($checkDigit == substr(strval($ISBNNumber), -1));

        // return array_sum(str_split($ISBNNumber)) % 10 == 0;
    }
}
