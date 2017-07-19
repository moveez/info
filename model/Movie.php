<?php
/**
 * Created by IntelliJ IDEA.
 * User: lalittanwar
 * Date: 09/07/17
 * Time: 12:44 AM
 */

namespace moveez\info\model;

use app\service\R;

class Movie
{

    protected $bean = null;

    function __construct($id = 0)
    {
        if (!empty($id)) {
            $this->bean = R::load("movie", $id);
        }
    }

    function bean()
    {
        return $this->bean;
    }

    public function byImdbID($imdbid)
    {
        $movie = $this->bean;
        if (empty($movie) || empty($movie->id)) {
            $movie = R::findOne("movie", "imdbid=?", array($imdbid));
        }
        if (empty($movie)) {
            $config = new \Imdb\Config();
            $config->cachedir = "build/imdb/";
            $ImdbMovie = new \Imdb\Title($imdbid, $config);
            //exit();
            $movie = R::dispense("movie");
            $movie->title = $ImdbMovie->title();
            $movie->titleorg = $ImdbMovie->orig_title();
            $movie->cover = $ImdbMovie->photo();
            $movie->year = $ImdbMovie->year();
            $movie->plotoutline = $ImdbMovie->plotoutline();

            $items = $ImdbMovie->country();
            foreach ($items as $item) {
                $movie->sharedCountry[] = Country::byTitle($item)->bean();;
            }

            $items = $ImdbMovie->languages();
            foreach ($items as $item) {
                $movie->sharedLang[] = Language::byTitle($item)->bean();
            }

            $items = $ImdbMovie->genres();
            foreach ($items as $item) {
                $movie->sharedGenre[] = Genre::byTitle($item)->bean();
            }

            $items = $ImdbMovie->keywords();
            foreach ($items as $item) {
                $movie->ownKeywordList[] = Keyword::byTitle($item)->bean();
            }

            $items = $ImdbMovie->alsoknow();
            foreach ($items as $item) {
                $movie->ownAkas[] = AkaTitle::byTitle(
                    $movie->id, $item["title"],
                    $item["country"], $item["lang"], $item["year"])
                    ->bean();
            }

            $items = $ImdbMovie->plot_split();
            foreach ($items as $item) {
                $movie->ownPlot[] = Plot::byText($movie->id, $item["plot"], $item["author"]["name"])
                    ->bean();
            }


            $items = $ImdbMovie->synopsis();
            echo $items;
            if (!empty($items)) {
                $movie->ownSynopsis[] = Synopsis::byText($movie->id, $items)->bean();
            }


            $items = $ImdbMovie->prodCompany();
            foreach ($items as $item) {
                $movie->sharedProduction[] = Production::byTitle($item["name"])
                    ->bean();
            }

            $items = $ImdbMovie->director();
            print_r($items);

            foreach ($items as $item) {
                $movie->ownDirectorList[] = PersonDirector::byTitle($item["name"])
                    ->imdbid($item["imdb"])
                    ->bean();
            }
            $items = $ImdbMovie->producer();
            foreach ($items as $item) {
                $movie->ownProducerList[] = PersonProducer::byTitle($item["name"])
                    ->imdbid($item["imdb"])
                    ->bean();
            }
            $items = $ImdbMovie->writing();
            foreach ($items as $item) {
                $movie->ownWriterList[] = PersonWriter::byTitle($item["name"])
                    ->imdbid($item["imdb"])
                    ->bean();
            }
            $items = $ImdbMovie->cast();
            foreach ($items as $item) {
                $movie->ownActorList[] = PersonActor::byTitle($item["name"], $item["role"])
                    ->imdbid($item["imdb"])
                    ->bean();
            }

            $movie->imdbid = $imdbid;
            R::store($movie);
            R::tag($movie, $ImdbMovie->keywords_all());
        }
        $this->bean = $movie;
    }

}