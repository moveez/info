<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class PersonActor extends Person
{
    public static $TABLE = "actor";

    static public function byTitle($title, $role = null)
    {
        $bean = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $person = R::findOneOrDispense(Person::$TABLE, "title=?", array($title));
            $person->title = $title;
            $bean = R::dispense(self::$TABLE);
            $bean->person = $person;
            $bean->role = $role;
        }
        return new PersonActor($bean->id, $bean);
    }
}