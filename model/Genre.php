<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class Genre extends BasicModel
{

    public static $TABLE = "genre";

    static public function byTitle($title)
    {
        $bean = null;
        if(!empty($title)){
            $bean = R::findOneOrDispense("genre", "title=?", array($title));
            $bean->title = $title;
        }
        return new Genre($bean->id, $bean);
    }
}