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

    static public function byTitle($title, $role = null)
    {
        $actor = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $person = R::findOneOrDispense("person", "title=?", array($title));
            $person->title = $title;
            $actor = R::dispense("actor");
            $actor->person = $person;
            $actor->role = $role;
        }
        return new PersonActor($actor);
    }
}