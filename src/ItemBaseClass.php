<?php

declare(strict_types=1);

namespace App;

class ItemBaseClass
{
    protected $ISBN;
    protected $bookName;
//    protected $authorSurname;
//    protected $authorFirstname;
    /**
     * ItemBaseClass constructor.
     * @param $ISBN
     * @param $bookName
//     * @param $authorSurname
//     * @param $authorFirstname
     */
    public function __construct($ISBN,
                                $bookName,
// $authorFirstname, $authorSurname
    ){
        $this ->ISBN =  $ISBN;
        $this->bookName = $bookName;
//        $this->authorFirstname = $authorFirstname;
//        $this->authorSurname = $authorSurname;
    }

}