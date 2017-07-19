<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 10/07/17
 * Time: 12:27 AM
 */

namespace moveez\info\model;


class BasicModel
{
    protected $bean;

    public function __construct($bean)
    {
        $this->bean = $bean;
    }

    public function bean()
    {
        return $this->bean;
    }

}