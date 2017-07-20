<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class AkaTitle extends BasicModel
{

    public static $TABLE = "akas";

    static public function byTitle($movie_id, $title, $country, $language, $year)
    {
        $bean = null;
        if (!empty($title)) {
            $bean = R::findOneOrDispense(self::$TABLE, "title=? AND country=? AND movie_id=?",
                array($title, $country, $movie_id));
            $bean->title = $title;
            $bean->country = Country::byTitle($country)->bean();
            $bean->year = $year;
            $bean->lang = Language::byTitle($language)->bean();
        }
        return new AkaTitle($bean->id, $bean);
    }
}