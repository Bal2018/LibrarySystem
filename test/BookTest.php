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

    public function testFailsWhenUserEntersEmptyTitle()
    {
        new Title("");
//        $this->sut = new Book($this->ISBN, $this->title);
//        $this->assertSame( $emptyTitle, $this->sut->getTitle());
        // this could be checked by
 //       $this->assertEmpty($emptyTitle, "Title is empty");

    }
    public function testFailsWhenUserEntersExtraHTMLTagsInTitle()
    {
        new Title("Hello <b>world!</b>");
//        $this->sut = new Book($this->ISBN, $this->title);
//        $this->asertSame( $emptyTitle, $this->sut->getTitle());
        // this could be checked by
        //       $this->assertEmpty($emptyTitle, "Title is empty");

    }
    public function testTitleIsNotJustSpaces()
    {
        new Title("                             ");
    }

    /**
     *  @dataProvider dataProviderForExtraLongTitles
     *
     */
    public function testFailsWhenUserEntersATitleLongerThan200Chars($incorrectTitle )
    {
        new Title($incorrectTitle);
//        $this->sut = new Book($this->ISBN, $this->title);
//        $this->assertSame( $emptyTitle, $this->sut->getTitle());
        // this could be checked by
        //       $this->assertEmpty($emptyTitle, "Title is empty");

    }

    public function dataProviderForExtraLongTitles()
    {
        return [
            "firstType" => [$incorrectTitle = "Captain underpants and the invasion of the incredibly char=168...123"],
            "secondType" => [$incorrectTitle = " Don't Get Too Comfortable: The Indignities of Coach Class, The Torments of Low Thread Count, The Never-Ending Quest for Artisanal Olive Oil, and Other First World Problems" ], //172 chars"
            "thirdType" => [$incorrectTitle = "Alphabet Juice: The Energies, Gists, and Spirits of Letters, Words, and Combinations Thereof; Their Roots, Bones, Innards, Piths, Pips, and Secret Parts, Tinctures, Tonics, and Essences; With Examples of Their Usage Foul and Savory"],  //232 chars"]
       	    "fourthType" => [$incorrectTitle =  "Cross Country: Fifteen Years and Ninety Thousand Miles on the Roads and Interstates of America Lewis and Clark, a Lot of Bad Motels, a Moving Van, Emily Post, Jack Kerouac,My Wife, My Mother-In-Law, Two Kids and Enough Coffee to Kill an Elephant"] //246 chars
        ];
            }

    /**
     * @dataProvider dataProviderForTitleErrorType
     *
     *
     * */
    public function testThrowsCorrectErrorTypeWhenTitleIsCreated($incorrectTitle, $expectedErrorType)
    {
        $this->expectException($expectedErrorType);
        $wrongNumber = new Title($incorrectTitle);  //format is 12 , needs to be 13 digits long
        $this->sut = new Book($this->ISBN, $wrongNumber);

    }

    public function dataProviderForTitleErrorType()
    {
        return [
            "firstType" => [$incorrectTitle = "",
                $expectedErrorType = \App\EmptyTitle::class],
            "secondType" => [$incorrectTitle = "Hello <b>world!</b>",
                    $expectedErrorType = \App\ExtraTagsInTitle::class],
            "thirdType" => [$incorrectTitle = "<blink><strong>Hello!</strong></blink>",
                    $expectedErrorType = \App\ExtraTagsInTitle::class],
            "fourthType" => [$incorrectTitle = "Noisy Outlaws, Unfriendly Blobs, and Some Other Things That Aren't as Scary, Maybe, Depending on How You Feel About Lost Lands, Stray Cellphones, Creatures From the Sky, Parents Who Disappear in Peru, a Man Named Lars Farf, and One Other Story We [...]",
                $expectedErrorType = \App\ExtraLongTitle::class] //255 chars
        ];
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
        $this->expectException($expectedErrorType);
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
                $expectedErrorType = "ERROR : Incorrect ISBN Format for [12467890123] - must be 13 digits long"],
            "secondMessage" => [$WrongISBNNumber = 12467-890123,
                $expectedErrorMessage = "ERROR : Incorrect ISBN Format - must be integer"],
            "thirdMessage" => [$WrongISBNNumber = 0000000000000,
                $expectedErrorType = "ERROR : Incorrect ISBN Format for [0] - must not be just zeros"]
        ];
    }
    public function testIncorrectISBNLengthThrowsErrorMessage()
    {
        $this->expectExceptionMessage("ERROR : Incorrect ISBN Format for - must be 13 digits long");
        $wrongNumber = new ISBN(24567890123);
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function testValidISBN()
    {
        $correctISBN = 9781857028898;
        $this->assertTrue($this->ISBN->checkValidISBN($correctISBN),"Invalid ISBN Number");
    }

//    public function testNumericISBN(): void
//    {
//        $this->sut = new Book($this->ISBN, $this->title);
//        $this->assertSame( 1234567890123, $this->sut->getISBNNumber());
//    }

//    public function testISBNNotZero()
//    {
//        $wrongNumber = new ISBN(0000000000000);
//        <<check that number is not zeros
//    }


}