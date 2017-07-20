<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class Plot extends BasicModel
{

    public static $TABLE = "plot";

    static public function byText($movie_id, $text = null, $authorname = null)
    {
        $bean = null;
        if (!empty($text)) {
            $bean = R::findOneOrDispense("plot", "text=? AND movie_id=?",
                array($text, $movie_id));
            $bean->text = $text;
            $bean->authorname = $authorname;
        }
        return new Plot($bean->id, $bean);
    }
}