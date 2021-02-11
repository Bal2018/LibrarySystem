<?php

use PHPUnit\Framework\TestCase;

use App\Book;

class BookTest extends TestCase
{
    private $sut;
    private $ISBN;
    private $title;
//SUT  ~ System Under Test
    protected function setUp(): void
    {
        $this->ISBN = 1234567890123;
        $this->title = "A Sunny Morning";
    }

    public function testUserDoesNotEnterEmptyStringsForTitle()
    {
        $this->sut = new Book($this->ISBN, $this->title);

        $this->assertSame( $this->title, $this->sut->getTitle());
    }



}