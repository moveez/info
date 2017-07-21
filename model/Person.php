<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class Person extends BasicModel
{

    public static $TABLE = "person";

    protected $imdbPerson = null;

    public function imdbPerson($imdbid)
    {
        if (empty($this->imdbPerson)) {
            $config = new \Imdb\Config();
            $config->cachedir = "build/imdb/";
            $this->imdbPerson = new \Imdb\Person($imdbid, $config);
        }
        return $this->imdbPerson;
    }

    public function imdbid($imdbid = null, $check = false)
    {
        if (empty($this->bean()->imdbid) || !$check) {
            $this->bean()->person->imdbid = $imdbid;
        }
        return $this;
    }

    public function syncImdb($fetchDeep = false)
    {
        if (!empty($this->bean->imdbid) && empty($this->bean->imdb_syncd)) {
            $imdbPerson = $this->imdbPerson($this->bean->imdbid);
            if (empty($this->bean->cover)) {
                $this->bean->cover = $imdbPerson->photo();
            }
            if (empty($this->bean->ownNicknameList)) {
                foreach ($imdbPerson->nickname() as $item) {
                    $nickname = R::dispense("nickname");
                    $nickname->title = $item;
                    $this->bean->ownNicknameList[] = $nickname;
                }
            }
            if (empty($this->bean->ownBirthList)) {
                $born = $imdbPerson->born();
                $birth = R::dispense("birth");
                $birth->name = $imdbPerson->birthname();
                $birth->day = $born["day"];
                $birth->month = $born["month"];
                $birth->year = $born["year"];
                $birth->place = $born["place"];
                $this->bean->ownBirthList[] = $birth;
            }

            $this->bean->imdb_syncd = 1;

            R::store($this->bean);
        }
    }

}
