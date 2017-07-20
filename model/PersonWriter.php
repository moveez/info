<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class PersonWriter extends Person
{

    public static $TABLE = "writer";

    static public function byTitle($title)
    {
        $bean = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $person = R::findOneOrDispense("person", "title=?", array($title));
            $person->title = $title;
            $bean = R::dispense("writer");
            $bean->person = $person;
        }
        return new PersonWriter($bean->id, $bean);
    }
}