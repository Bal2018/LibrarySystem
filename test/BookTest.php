<?php

use PHPUnit\Framework\TestCase;

use App\Book;

class BookTest extends TestCase
{
    private $sut;
    private $ISBN;
//SUT  ~ System Under Test

    public function testUserDoesNotEnterEmptyStringsForTitle(){
        $userISBN = 1234567890123;
        $title ="A Sunny Morning";
        $this->sut = new Book($userISBN,$title);
        $expectedResult = "Nop";
        $this->assertSame($expectedResult, $this->sut->enterAuthorDetails());

    }

}