<?php

use PHPUnit\Framework\TestCase;

use App\Book;

class BookTest extends TestCase
{
    private $sut;
    private \App\ISBN $ISBN;
    private $title;

    protected function setUp(): void
    {
        $this->ISBN = new \App\ISBN(1234567890123);
        $this->title = "A Sunny Morning";
    }

    public function testUserDoesNotEnterEmptyStringsForTitle()
    {
        $this->sut = new Book($this->ISBN, $this->title);
        $this->assertSame( $this->title, $this->sut->getTitle());
    }

    public function testThrowsCorrectErrorType()
    {
        $this->expectException(InvalidArgumentException::class);
        $wrongNumber = new \App\ISBN(124567890123);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function testIncorrectThrowsErrorMessage()
    {
        $this->expectExceptionMessage("ERROR ISBN must be 13 digits");
        $wrongNumber = new \App\ISBN(124567890123);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function testNumericISBN(): void
    {
        $this->sut = new Book($this->ISBN, $this->title);
        $this->assertSame( 1234567890123, $this->sut->getISBNNumber());
    }

}