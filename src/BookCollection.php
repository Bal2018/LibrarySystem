<?php

namespace App;

class BookCollection
{
    protected function getAllBooks()
    {
        return [
            new Book(9780199535569, "Pride and Prejudice"),
            new Book(9781526603180, "Space Detectives"),
            new Book(9781471182617, "The Littlest Yak"),
            new Book(9780670913503, "Hairy Maclary from Donaldson's Dairy - Hairy Maclary and Friends"),
            new Book(9781509804788, "A Squash and a Squeeze"),
            new Book(9781309804781, "An invalid book title")
        ];
    }

    /**
     * @param int $ISBNNumber
     * @return bool
     */
    public function getBookUsingISBN($ISBNNumber): bool
    {
        foreach ($this->getAllBooks() as &$book) {
            if ($book->getISBNNumber() == $ISBNNumber) {
                return true;
            }
        }
        return false;
    }

    public function getBookDetailsUsingISBN($ISBNNumber): ?Book
    {
        foreach ($this->getAllBooks() as &$book) {
            if ($book->getISBNNumber() == $ISBNNumber) {
                return $book;
            }
        }
        return null;
    }
}
