<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class PersonProducer extends Person
{

    public static $TABLE = "producer";

    static public function byTitle($title)
    {
        $bean = null;
        if (!empty($title)) {
            $title = strip_tags($title);
            $person = R::findOneOrDispense("person", "title=?", array($title));
            $person->title = $title;
            $bean = R::dispense("producer");
            $bean->person = $person;
        }
        return new PersonProducer($bean->id, $bean);
    }
}