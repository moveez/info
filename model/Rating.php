<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 1:36 PM
 */

namespace moveez\info\model;

use app\service\R;

class Rating extends BasicModel
{

    public static $TABLE = "rating";

    public function imdb($rating, $votes)
    {
        $this->bean->imdbrating = $rating;
        $this->bean->imdbvotes = $votes;

        if (empty($this->bean->rating)) {
            $this->bean->rating = round($rating);
        }

        return $this;
    }


}