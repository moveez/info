<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class Synopsis extends BasicModel
{

    static public function byText($movie_id, $text)
    {
        $bean = null;
        if (!empty($text)) {
            $bean = R::findOneOrDispense("synopsis", "text=? AND movie_id=?",
                array($text, $movie_id));
            $bean->text = $text;
        }
        return new Synopsis($bean);
    }
}