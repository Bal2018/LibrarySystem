<?php

use App\IncorrectISBNZeros;
//use App\ISBN;
//use App\Title;
use PHPUnit\Framework\TestCase;

use App\Book;
use App\IncorrectISBNFormat;


class BookCollectionTest extends TestCase
{
    private Book $sut;
    private string $title;
    private  int $ISBN;
    private \App\BookCollection $library;
    private \App\ItemBaseClass $base;


    protected function setUp(): void
    {
        try {
             $this->ISBN   = 1234567890123;
        } catch (IncorrectISBNFormat $e) {
        }
        $this->title = "A Sunny Morning";
    }

    public function testFailsWhenUserEntersEmptyTitle()
    {
        $this->title = "";
    }
    public function testFailsWhenUserEntersExtraHTMLTagsInTitle()
    {
        $this->title = "Hello <b>world!</b>";
        // this could be checked by
        //       $this->assertEmpty($emptyTitle, "Title is empty");

    }
    public function testTitleIsNotJustSpaces()
    {
        $this->title = ("                             ");
    }

    /**
     *  @dataProvider dataProviderForExtraLongTitles
     *
     */
    public function testFailsWhenUserEntersATitleLongerThan200Chars($incorrectTitle )
    {
        $this->title =($incorrectTitle);
//        $this->sut = new Book($this->ISBN, $this->title);
//        $this->assertSame( $emptyTitle, $this->sut->getTitle());
        // this could be checked by
        //       $this->assertEmpty($emptyTitle, "Title is empty");

    }

    public function dataProviderForExtraLongTitles()
    {
        return [
            "firstTitle" => [$incorrectTitle = "Captain underpants and the invasion of the incredibly char=168...123"],
            "secondTitle" =>[$incorrectTitle = "Don't Get Too Comfortable: The Indignities of Coach Class, The Torments of Low Thread Count, The Never-Ending Quest for Artisanal Olive Oil, and Other First World Problems" ], //172 chars"
            "thirdTitle" => [$incorrectTitle = "Alphabet Juice: The Energies, Gists, and Spirits of Letters, Words, and Combinations Thereof; Their Roots, Bones, Innards, Piths, Pips, and Secret Parts, Tinctures, Tonics, and Essences; With Examples of Their Usage Foul and Savory"],  //232 chars"]
       	    "fourthTitle" =>[$incorrectTitle = "Cross Country: Fifteen Years and Ninety Thousand Miles on the Roads and Interstates of America Lewis and Clark, a Lot of Bad Motels, a Moving Van, Emily Post, Jack Kerouac,My Wife, My Mother-In-Law, Two Kids and Enough Coffee to Kill an Elephant"] //246 chars
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

        $this->sut = new Book($this->ISBN, $incorrectTitle);  // title must be 13 digits long;

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
     * @dataProvider dataProviderForErrorMessagesAndTypes
     *
     * Test : to check the correct type of error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $wrongISBNNumber
     * @param $expectedErrorType
     * @throws IncorrectISBNFormat
     * @throws IncorrectISBNZeros
     */
    public function testThrowsCorrectErrorTypeWhenISBNCreated($wrongISBNNumber,$expectedErrorType )
    {
        $this->expectException($expectedErrorType);

        $this->sut = new Book($wrongISBNNumber, $this->title);
        $this->sut->getISBNNumber();
    }

//    public function dataProviderForErrorType()
//    {
//        return [
//            "firstType" => [$WrongISBNNumber = 12467890123,
//                $expectedErrorType = IncorrectISBNFormat::class],
//            "secondType" => [$WrongISBNNumber = 12467-890123,
//                $expectedErrorType = InvalidArgumentException::class],
//            "thirdType" => [$WrongISBNNumber = 0000000000000,
//                $expectedErrorType = IncorrectISBNZeros::class]
//        ];
//    }
    /**
     * @dataProvider dataProviderForErrorMessagesAndTypes
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $wrongISBNNumber
     * @param $expectedErrorMessage
     * @throws IncorrectISBNFormat
     * @throws IncorrectISBNZeros
     */
    public function testIncorrectISBNCorrectErrorMessage($wrongISBNNumber,$expectedErrorMessage)
    {
        $this->expectExceptionMessage($expectedErrorMessage);

        $this->sut = new Book($wrongISBNNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    public function dataProviderForErrorMessagesAndTypes()
    {
        return [
            "firstMessage" =>  [$WrongISBNNumber = 12467890123,
                                $expectedErrorMessage = 'ERROR : Incorrect ISBN Format for 12467890123 - must be 13 digits long',
                                $expectedErrorType = IncorrectISBNFormat::class],
            "secondMessage" => [$WrongISBNNumber = 12467-890123,
                                $expectedErrorMessage = "ERROR : Incorrect ISBN Format - must be integer",
                                $expectedErrorType = InvalidArgumentException::class],
            "thirdMessage" =>  [$WrongISBNNumber = 0000000000000,
                                $expectedErrorMessage = "ERROR : Incorrect ISBN Format for [0] - must not be just zeros",
                                $expectedErrorType = IncorrectISBNZeros::class]
        ];
    }
    public function testIncorrectISBNLengthThrowsErrorMessage()
    {
        $this->expectExceptionMessage("ERROR : Incorrect ISBN Format for - must be 13 digits long");
        $wrongNumber =  24567890123 ;
        $this->sut = new Book($wrongNumber, $this->title);
        $this->sut->getISBNNumber();
    }

    /**
     * @dataProvider dataProviderBookDetails
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $ISBN
     */
//    public function testValidISBN($ISBN)
//    {
//        $correctISBN = $ISBN;
//        $this->assertTrue($this->base->);
//        $this->assertTrue($this->\App\ItemBaseClass::checkValidISBN($correctISBN),"Invalid ISBN Number");
// //           checkValidISBN($correctISBN),"Invalid ISBN Number");
//    }

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

    /**
     * @dataProvider dataProviderBookDetails
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $ISBN
     */
    public function testToCheckIfBookExistsUsingISBN($ISBN)
    {
        $ISBNToSearch = $ISBN;
        $this->assertTrue(($this->ISBN->getBookUsingISBN($ISBNToSearch)),"Invalid ISBN Number n- Book not in library system");
    }
    /**
     * @dataProvider dataProviderBookDetails
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $ISBN
     */
    public function testReturnBookDetails($ISBN, $title )
    {
        $titleReturned ='';
        $ISBNToSearch = $ISBN;
        $this->assertTrue(($this->ISBN->getBookUsingISBN($ISBNToSearch)),"Invalid ISBN Number n- Book not in library system");
        $titleReturned= $this->ISBN->getBookDetailsUsingISBN($ISBNToSearch);
        echo ">".$titleReturned."<";
    }
//    public function testToGetBookDetailsUsingISBN()
//    {
//        $ISBNToSearch = 9781479182617;
//        $this->assertTrue(($this->ISBN->getBookUsingISBN($ISBNToSearch)),"Invalid ISBN Number n- Book not in library system");
//
//    }


    public function dataProviderBookDetails()
    {
        return [
            "firstBook"     => ["ISBN"=>9780199535569, "title"=>"Pride and Prejudice"],
            "secondBook"    => ["ISBN"=>9781526603180, "title"=>"Space Detectives"],
            "thirdBook"     => ["ISBN"=>9781471182617, "title"=>"The Littlest Yak"],
            "fourthBook"    => ["ISBN"=>9780670913503, "title"=>"Hairy Maclary from Donaldson's Dairy - Hairy Maclary and Friends"],
            "fifthBook"     => ["ISBN"=>9781509804788, "title"=>"A Squash and a Squeeze"],
            "invalidBook1"  => ["ISBN"=>9781309804781, "title"=>"An invalid book title"],
        ];
    }

}