<?php

namespace App;

use App\EmptyTitle;
use App\ExtraLongTitle;
use App\ExtraTagsInTitle;

class Title
{
    protected string $title;

    /**
     * Title constructor.
     * @param $title
     * @throws EmptyTitle
     * @throws \App\ExtraLongTitle
     * @throws \App\ExtraTagsInTitle
     * @throws \App\OnlyWhiteSpaceInTitle
     */
    public function __construct($title)
    {
        if (empty($title)) {
            throw EmptyTitle::titleIsEmpty();
        }
        if ($title != strip_tags($title))
        {
            throw ExtraTagsInTitle::withExtraTags($title);
        }
        if (strlen($title) > 180){
            throw ExtraLongTitle::withLongTitle($title);
        }
        if (ctype_space($title)) {
            throw OnlyWhiteSpaceInTitle::withWhiteSpaces();
        }
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}