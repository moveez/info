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

    static public function byTitle($title)
    {
        $keyword = null;
        if(!empty($title)){
            $title = strip_tags($title);
            $tag = R::findOneOrDispense("tag", "title=?", array($title));
            $tag->title = $title;
            $keyword = R::dispense("keyword");
            $keyword->tag = $tag;
        }
        return new Keyword($keyword);
    }
}