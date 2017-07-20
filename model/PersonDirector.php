<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class PersonDirector extends Person
{

    public static $TABLE = "director";

    static public function byTitle($title)
    {
        $bean = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $person = R::findOneOrDispense("person", "title=?", array($title));
            $person->title = $title;
            $bean = R::dispense("director");
            $bean->person = $person;
        }
        return new PersonDirector($bean->id, $bean);
    }
}