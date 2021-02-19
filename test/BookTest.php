<?php

use App\ISBN;
use App\Title;
use PHPUnit\Framework\TestCase;

use App\Book;
use App\IncorrectISBNFormat;


class BookTest extends TestCase
{
    private Book $sut;
    private ISBN $ISBN;
    private string $title;

    protected function setUp(): void
    {
        try {
            $this->ISBN = new ISBN(1234567890123);
        } catch (IncorrectISBNFormat $e) {
        }
        $this->title = "A Sunny Morning";
    }

    public function testTestFailsWhenUserEntersEmptyTitle()
    {
        $emptyTitle = new Title("");
//        $this->sut = new Book($this->ISBN, $this->title);
//        $this->assertSame( $emptyTitle, $this->sut->getTitle());
        // this could be checked by
        $this->assertEmpty($emptyTitle, "Title is empty");
    }

    public function testUserDoesNotEnterEmptyStringsForTitle()
    {
        $this->sut = new Book($this->ISBN, $this->title);
        $this->assertSame( $this->title, $this->sut->getTitle());
    }

//        checking TYPE of exception thrown
    public function testThrowsCorrectErrorTypeWhenISBNCreated()
    {
        $this->expectException(exception: IncorrectISBNFormat::class);
        $wrongNumber = new ISBN(12467890123);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function testIncorrectISBNCorrectErrorMessage()
    {
        $this->expectExceptionMessage("ERROR : ISBN must be a integer");
        $wrongNumber = new ISBN(2-4567890123);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function testIncorrectISBNLengthThrowsErrorMessage()
    {
        $this->expectExceptionMessage("ERROR : Incorrect ISBN Format - must be 13 digits long");
        $wrongNumber = new ISBN(24567890123);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function testNumericISBN(): void
    {
        $this->sut = new Book($this->ISBN, $this->title);
        $this->assertSame( 1234567890123, $this->sut->getISBNNumber());
    }

    public function testValidISBN()
    {
        $correctISBN = 9781857028898;
        $this->assertTrue($this->ISBN->checkValidISBN($correctISBN),"Invalid ISBN Number");
    }

//    public function testISBNNotZero()
//    {
//        $wrongNumber = new ISBN(0000000000000);
//        <<check that number is not zeros
//    }


}