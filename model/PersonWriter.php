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

    static public function byTitle($title)
    {
        $writer = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $person = R::findOneOrDispense("person", "title=?", array($title));
            $person->title = $title;
            $writer = R::dispense("writer");
            $writer->person = $person;
        }
        return new PersonWriter($writer);
    }
}