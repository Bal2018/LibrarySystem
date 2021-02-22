<?php

use App\IncorrectISBNZeros;
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

    public function testUserEntersSomethingForTheTitle()
    {
        $this->sut = new Book($this->ISBN, $this->title);
        $this->assertSame( $this->title, $this->sut->getTitle());
    }

//        checking TYPE of exception thrown
    /**
     * @dataProvider dataProviderForErrorType
     *
     * Test : to check the correct type of error message is returned from ISBN construct function depending upon what is stored in the data module
     *
     */
    public function testThrowsCorrectErrorTypeWhenISBNCreated($wrongISBNNumber,$expectedErrorType )
    {
        $this->expectException(exception: $expectedErrorType);
        $wrongNumber = new ISBN($wrongISBNNumber);  //format is 12 , needs to be 13 digits long
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function dataProviderForErrorType()
    {
        return [
            "firstType" => [$WrongISBNNumber = 12467890123,
                $expectedErrorType = IncorrectISBNFormat::class],
            "secondType" => [$WrongISBNNumber = 12467-890123,
                $expectedErrorType = InvalidArgumentException::class],
            "thirdType" => [$WrongISBNNumber = 0000000000000,
                $expectedErrorType = IncorrectISBNZeros::class]
        ];
    }
    /**
     * @dataProvider dataProviderForErrorMessage
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     *
     */
    public function testIncorrectISBNCorrectErrorMessage($wrongISBNNumber,$expectedErrorMessage)
    {
        $this->expectExceptionMessage($expectedErrorMessage);
        $wrongNumber = new ISBN($wrongISBNNumber);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }
    public function dataProviderForErrorMessage()
    {
        return [
            "firstMessage" => [$WrongISBNNumber = 12467890123,
                $expectedErrorType = "ERROR : Incorrect ISBN Format - must be 13 digits long"],
            "secondMessage" => [$WrongISBNNumber = 12467-890123,
                $expectedErrorMessage = "ERROR : ISBN must be a integer"],
            "thirdMessage" => [$WrongISBNNumber = 0000000000000,
                $expectedErrorType = "ERROR : Incorrect ISBN Value - must not be zeros"]
        ];
    }
    public function testIncorrectISBNLengthThrowsErrorMessage()
    {
        $this->expectExceptionMessage("ERROR : Incorrect ISBN Format - must be 13 digits long");
        $wrongNumber = new ISBN(24567890123);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

//    public function testNumericISBN(): void
//    {
//        $this->sut = new Book($this->ISBN, $this->title);
//        $this->assertSame( 1234567890123, $this->sut->getISBNNumber());
//    }

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