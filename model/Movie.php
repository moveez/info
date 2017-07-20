<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 12:44 AM
 */

namespace moveez\info\model;

use app\service\R;

class Movie extends BasicModel
{

    public static $TABLE = "movie";

    /**
     * @var \Imdb\Title
     */
    protected $imdbMovie = null;

    /**
     * @param $imdbid
     *
     * @return \Imdb\Title
     */
    public function imdbMovie($imdbid)
    {
        if (empty($this->imdbMovie)) {
            $config = new \Imdb\Config();
            $config->cachedir = "build/imdb/";
            $this->imdbMovie = new \Imdb\Title($imdbid, $config);
        }
        return $this->imdbMovie;
    }

    public function fetchImdb($imdbid, $fetchDeep = false)
    {
        $bean = $this->bean;

        if (empty($bean)) {
            $bean = R::findOne("movie", "imdbid=?", array($imdbid));
        }

        if (empty($bean)) {
            $bean = R::dispense("movie");
        }

        if (empty($bean->id)) {

            $ImdbMovie = $this->imdbMovie($imdbid);

            $bean->imdbid = $imdbid;
            $bean->title = $ImdbMovie->title();
            $bean->titleorg = $ImdbMovie->orig_title();
            $bean->cover = $ImdbMovie->photo();
            $bean->year = $ImdbMovie->year();
            $bean->plotoutline = $ImdbMovie->plotoutline();

            $items = $ImdbMovie->country();
            foreach ($items as $item) {
                $bean->sharedCountry[] = Country::byTitle($item)->bean();;
            }

            $items = $ImdbMovie->languages();
            foreach ($items as $item) {
                $bean->sharedLang[] = Language::byTitle($item)->bean();
            }

            $items = $ImdbMovie->genres();
            foreach ($items as $item) {
                $bean->sharedGenre[] = Genre::byTitle($item)->bean();
            }

            $items = $ImdbMovie->keywords();
            foreach ($items as $item) {
                $bean->ownKeywordList[] = Keyword::byTitle($item)->bean();
            }

            $items = $ImdbMovie->alsoknow();
            foreach ($items as $item) {
                $bean->ownAkas[] = AkaTitle::byTitle(
                    $bean->id, $item["title"],
                    $item["country"], $item["lang"], $item["year"])
                    ->bean();
            }

            $items = $ImdbMovie->plot_split();
            foreach ($items as $item) {
                $bean->ownPlot[] = Plot::byText($bean->id, $item["plot"], $item["author"]["name"])
                    ->bean();
            }

            $items = $ImdbMovie->synopsis();
            if (!empty($items)) {
                $bean->ownSynopsis[] = Synopsis::byText($bean->id, $items)->bean();
            }

            if ($fetchDeep) {
                $items = $ImdbMovie->prodCompany();
                foreach ($items as $item) {
                    $bean->sharedProduction[] = Production::byTitle($item["name"])
                        ->bean();
                }

                $items = $ImdbMovie->director();
                foreach ($items as $item) {
                    $bean->ownDirectorList[] = PersonDirector::byTitle($item["name"])
                        ->imdbid($item["imdb"])
                        ->bean();
                }
                $items = $ImdbMovie->producer();
                foreach ($items as $item) {
                    $bean->ownProducerList[] = PersonProducer::byTitle($item["name"])
                        ->imdbid($item["imdb"])
                        ->bean();
                }
                $items = $ImdbMovie->writing();
                foreach ($items as $item) {
                    $bean->ownWriterList[] = PersonWriter::byTitle($item["name"])
                        ->imdbid($item["imdb"])
                        ->bean();
                }
                $items = $ImdbMovie->cast();
                foreach ($items as $item) {
                    $bean->ownActorList[] = PersonActor::byTitle($item["name"], $item["role"])
                        ->imdbid($item["imdb"])
                        ->bean();
                }
            }
            R::store($bean);
            R::tag($bean, $ImdbMovie->keywords_all());
        }
        $this->bean = $bean;
    }

    public function syncImdb($fetchDeep = false)
    {
        if (!empty($this->bean->imdbid) && empty($this->bean->imdb_syncd)) {
            $imdbMovie = $this->imdbMovie($this->bean->imdbid);
            if (empty($this->bean->cover)) {
                $this->bean->cover = $imdbMovie->photo();
            }
            if (empty($this->bean->year)) {
                $this->bean->year = $imdbMovie->year();
            }

            if (empty($this->bean->rating)) {
                $this->bean->rating = (new Rating(0, $this->bean->rating))
                    ->imdb($imdbMovie->rating(), $imdbMovie->votes())->bean();
            }

            $this->bean->imdb_syncd = 1;

            R::store($this->bean);
        }
    }

}