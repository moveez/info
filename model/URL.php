<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 20/07/17
 * Time: 12:32 PM
 */

namespace moveez\info\model;


class URL
{

    public static $IMDB_MOVIE_URL = "/(https?:)\/\/(.*)\.imdb\.com\/title\/(tt[0-9]+)/";

    //Flags
    public $isIMDB = false;
    public $isMOVIE = false;
    public $isPERSON = false;
    public $isCOMPANY = false;

    //Values
    public $movie_id = null;

    public function __construct($url)
    {
        $match = null;
        if (preg_match(self::$IMDB_MOVIE_URL, $url, $match) == 1) {
            $this->isIMDB = TRUE;
            $this->isMOVIE = TRUE;
            $this->movie_id = $match[3];
        }
    }

}