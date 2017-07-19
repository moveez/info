<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

class Person extends BasicModel
{

    public function imdbid($imdbid = null, $check = false)
    {
        if (empty($this->bean()->imdbid) || !$check) {
            $this->bean()->person->imdbid = $imdbid;
        }
        return $this;
    }
}