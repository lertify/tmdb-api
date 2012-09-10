<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Exception;
use Lertify\TMDb\Api\Data\Misc AS MiscData;
use Lertify\TMDb\Api\Data\Movie AS MovieData;
use Lertify\TMDb\Api\Data\Authentication\Session;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Misc extends AbstractApi
{

    /**
     * Add movie rating
     *
     * @link http://help.themoviedb.org/kb/api/movie-add-rating
     *
     * @param string|Session $session Session id or object
     * @param integer|MovieData\ShortInfo $movie Movie id or object
     * @param float $rating rating between 1 and 10
     * @throws \InvalidArgumentException
     * @return bool
     */
    public function addRating( $session, $movie, $rating ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $movie instanceof MovieData\ShortInfo ) $movie_id = $movie->getId();
        else $movie_id = $movie;

        if( $rating < 1 || $rating > 10) throw new \InvalidArgumentException("Rating should be between 1 and 10");

        $this->get('movie/'.$movie_id.'/rating'
            , array(
                'session_id' => $session_id
            ), array(
                'post' => array(
                    'value' => $rating
                )
            )
        );

        return true;
    }

    /**
     * Get the newest movie that was added to TMDb.
     *
     * @link http://help.themoviedb.org/kb/api/latest-movie
     *
     * @return MiscData\Movie
     * @throws Exception\NotFoundException
     */
    public function getLatestMovie() {
        $movie = $this->get('movie/latest');

        if(!isset($movie['id'])) throw new Exception\NotFoundException();

        // Wrap Collection info
        $movie['belongs_to_collection'] = new MovieData\Collection( $movie['belongs_to_collection']);

        // Wrap Genres
        $genres = new ArrayCollection();
        foreach( $movie['genres'] AS $genre ) {
            $genres->set( $genre['id'], new MovieData\Genre($genre) );
        }
        $movie['genres'] = $genres;

        // Wrap companies
        $companies = new ArrayCollection();
        foreach( $movie['production_companies'] AS $company ) {
            $companies->add( new MovieData\Company($company) );
        }
        $movie['production_companies'] = $companies;

        // Wrap countries
        $countries = new ArrayCollection();
        foreach( $movie['production_countries'] AS $country ) {
            $countries->add( new MovieData\Country($country) );
        }
        $movie['production_countries'] = $countries;

        // Wrap languages
        $languages = new ArrayCollection();
        foreach( $movie['spoken_languages'] AS $language ) {
            $languages->add( new MovieData\Language($language) );
        }
        $movie['spoken_languages'] = $languages;

        return new MiscData\Movie($movie);
    }

    /**
     * Get the movies currently in theatres.
     *
     * @link http://help.themoviedb.org/kb/api/now-playing-movies
     *
     * @return Data\PagedCollection
     * @throws Exception\PageNotFoundException
     */
    public function getNowPlaying() {
        $self = $this;
        $page_callback = function($page) use($self) {
            $results = $self->get('movie/now_playing', array('page' => $page));

            if(!isset($results['results'])) throw new Exception\PageNotFoundException();

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new MiscData\NowPlaying($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

    /**
     * Get the daily movie popularity list
     *
     * @link http://help.themoviedb.org/kb/api/popular-movie-list
     *
     * @return Data\PagedCollection
     * @throws Exception\PageNotFoundException
     */
    public function getPopular() {
        $self = $this;
        $page_callback = function($page) use($self) {
            $results = $self->get('movie/popular', array('page' => $page));

            if(!isset($results['results'])) throw new Exception\PageNotFoundException();

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new MiscData\Popular($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

    /**
     * Get the top rated movies that have over 10 votes on TMDb
     *
     * @link http://help.themoviedb.org/kb/api/top-rated-movies
     *
     * @return Data\PagedCollection
     * @throws Exception\PageNotFoundException
     */
    public function getTopRated() {
        $self = $this;
        $page_callback = function($page) use($self) {
            $results = $self->get('movie/top_rated', array('page' => $page));

            if(!isset($results['results'])) throw new Exception\PageNotFoundException();

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new MiscData\TopRated($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

}
