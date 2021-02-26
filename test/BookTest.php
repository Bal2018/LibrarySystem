<?php

use App\IncorrectISBNZeros;
//use App\ISBN;
//use App\Title;
use PHPUnit\Framework\TestCase;

use App\Book;
use App\IncorrectISBNFormat;


class BookTest extends TestCase
{
    private string $title;
    private int $ISBN;
    private \App\BookCollection $library;

    protected function setUp(): void
    {
        $this->ISBN =  1234567890123;
        $this->title = "A Sunny Morning";

        $this->library = new \App\BookCollection();
    }

    public function testFailsWhenUserEntersEmptyTitle()
    {
        $this->expectExceptionMessage('Incorrect Title - must not be empty');
        $book = new Book($this->ISBN,"");

    }

    public function testFailsWhenUserEntersExtraHTMLTagsInTitle()
    {
        $this->expectExceptionMessage('ERROR : Extra information entered with title - [Hello <b>world!</b>]');
        $book = new Book($this->ISBN,"Hello <b>world!</b>");

    }

    public function testTitleIsNotJustSpaces()
    {

        $this->expectExceptionMessage('ERROR : Title must not be just spaces');
        $book = new Book($this->ISBN,"           ");
    }

    /**
     * @dataProvider dataProviderForExtraLongTitles
     * @param $incorrectTitle
     * @throws \App\EmptyTitle
     * @throws \App\ExtraLongTitle
     * @throws \App\ExtraTagsInTitle
     * @throws \App\OnlyWhiteSpaceInTitle
     */
    public function testFailsWhenUserEntersATitleLongerThan200Chars($incorrectTitle )
    {
            $this->expectExceptionMessage('ERROR : Extra long title entered - Title must be < 180 chars');
            $book = new Book($this->ISBN,$incorrectTitle);
    }

    public function dataProviderForExtraLongTitles()
    {
        return [
//            "firstTitle" => [$incorrectTitle = "Captain underpants and the invasion of the incredibly char=168...123"],
//            "secondTitle" =>[$incorrectTitle = "Don't Get Too Comfortable: The Indignities of Coach Class, The Torments of Low Thread Count, The Never-Ending Quest for Artisanal Olive Oil, and Other First World Problems" ], //172 chars"
            "thirdTitle" => [$incorrectTitle = "Alphabet Juice: The Energies, Gists, and Spirits of Letters, Words, and Combinations Thereof; Their Roots, Bones, Innards, Piths, Pips, and Secret Parts, Tinctures, Tonics, and Essences; With Examples of Their Usage Foul and Savory"],  //232 chars"]
       	    "fourthTitle" =>[$incorrectTitle = "Cross Country: Fifteen Years and Ninety Thousand Miles on the Roads and Interstates of America Lewis and Clark, a Lot of Bad Motels, a Moving Van, Emily Post, Jack Kerouac,My Wife, My Mother-In-Law, Two Kids and Enough Coffee to Kill an Elephant"] //246 chars
        ];
    }

    /**
     * @dataProvider dataProviderForTitleErrorType
     *
     *
     * @param $incorrectTitle
     * @param $expectedErrorType
     * @throws IncorrectISBNFormat
     * @throws IncorrectISBNZeros
     * @throws \App\EmptyTitle
     * @throws \App\ExtraLongTitle
     * @throws \App\ExtraTagsInTitle
     * @throws \App\OnlyWhiteSpaceInTitle
     */
    public function testThrowsCorrectErrorTypeWhenTitleIsCreated($incorrectTitle, $expectedErrorType)
    {
        $this->expectException($expectedErrorType);
        $book = new Book($this->ISBN, $incorrectTitle);
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
    public function testThrowsCorrectErrorTypeWhenISBNCreated($wrongISBNNumber,$expectedErrorMessage,$expectedErrorType )
    {
        $this->expectException($expectedErrorType);
        $book = new Book($wrongISBNNumber, $this->title);

    }

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
        $book =  new Book($wrongISBNNumber, $this->title);
    }

    public function dataProviderForErrorMessagesAndTypes()
    {
        return [
            "firstMessage" =>  [$WrongISBNNumber = 12467890123,
                                $expectedErrorMessage = 'ERROR : Incorrect ISBN Format for [12467890123] - must be 13 digits long',
                                $expectedErrorType = IncorrectISBNFormat::class],
            "secondMessage" => [$WrongISBNNumber = 12467-890123,
                                $expectedErrorMessage = "ERROR : Incorrect ISBN Format - must be integer",
                                $expectedErrorType = InvalidArgumentException::class],
            "thirdMessage" =>  [$WrongISBNNumber = 0000000000000,
                                $expectedErrorMessage = "ERROR : Incorrect ISBN Format for [0] - must not be just zeros",
                                $expectedErrorType = IncorrectISBNZeros::class]
        ];
    }


    /**
     * @dataProvider dataProviderBookDetails
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $correctISBN
     * @throws Exception
     */
    public function testValidISBN($correctISBN)
    {

        $this->assertTrue(Book::checkValidISBN($correctISBN),"Invalid ISBN Number");
    }

    /**
     * @dataProvider dataProviderBookDetails
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $ISBN
     */
    public function testToCheckIfBookExistsUsingISBN($ISBNToSearch)
    {
        $this->assertTrue(($this->library->getBookUsingISBN($ISBNToSearch)),"Invalid ISBN Number n- Book not in library system");
    }
    /**
     * @dataProvider dataProviderBookDetails
     *
     * Test : to check the correct error message is returned from ISBN construct function depending upon what is stored in the data module
     * @param $ISBN
     */
    public function testReturnBookDetails($ISBNToSearch, $title )
    {
        $this->assertTrue(($this->library->getBookUsingISBN($ISBNToSearch)),"Invalid ISBN Number n- Book not in library system");
        $book = $this->library->getBookDetailsUsingISBN($ISBNToSearch);
        $this->assertNotNull($book,"Book Doesn't exist");
        $this->assertSame($title, $book->getTitle());
    }

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