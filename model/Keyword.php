<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class Keyword extends BasicModel
{
    public static $TABLE = "keyword";

    static public function byTitle($title)
    {
        $bean = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $tag = R::findOneOrDispense("tag", "title=?", array($title));
            $tag->title = $title;
            $bean = R::dispense("keyword");
            $bean->tag = $tag;
        }
        return new Keyword($bean->id, $bean);
    }
}