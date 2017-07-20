<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 10/07/17
 * Time: 12:27 AM
 */

namespace moveez\info\model;

use app\service\R;

class BasicModel implements \JsonSerializable
{
    protected $bean;
    protected $bean_id = 0;

    public function __construct($bean_id = 0, $bean = null)
    {
        if (!empty($bean_id)) {
            $this->bean_id = $bean_id;
        }
        if (!empty($bean)) {
            $this->bean = $bean;
            $this->bean_id = $bean->id;
        }
        if (empty($this->bean)) {
            $this->bean = R::load(static::$TABLE, $this->bean_id);
        }
    }

    public function save()
    {
        $this->bean_id = R::store($this->bean);
        return $this->bean_id;
    }

    public function bean()
    {
        return $this->bean;
    }

    function jsonSerialize()
    {
        return $this->bean;
    }
}