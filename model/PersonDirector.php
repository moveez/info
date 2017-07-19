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

    static public function byTitle($title)
    {
        $director = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $person = R::findOneOrDispense("person", "title=?", array($title));
            $person->title = $title;
            $director = R::dispense("director");
            $director->person = $person;
        }
        return new PersonDirector($director);
    }
}