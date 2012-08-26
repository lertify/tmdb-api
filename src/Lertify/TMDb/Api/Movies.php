<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Exception;
use Lertify\TMDb\Api\Data\Movie AS Data;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Movies extends AbstractApi
{

    /**
     * Get movie info
     *
     * @link http://help.themoviedb.org/kb/api/movie-info
     *
     * @param integer $id ID of the movie
     * @return Data\Movie
     * @throws Exception\NotFoundException
     */
    public function getInfo( $id ) {
        $movie = $this->get('movie/' . $id);

        if(!isset($movie['id'])) throw new Exception\NotFoundException();

        // Wrap Collection info
        $movie['belongs_to_collection'] = new Data\Collection($movie['belongs_to_collection']);

        // Wrap Genres
        $genres = new ArrayCollection();
        foreach( $movie['genres'] AS $genre ) {
            $genres->set( $genre['id'], new Data\Genre($genre) );
        }
        $movie['genres'] = $genres;

        // Wrap companies
        $companies = new ArrayCollection();
        foreach( $movie['production_companies'] AS $company ) {
            $companies->add( new Data\Company($company) );
        }
        $movie['production_companies'] = $companies;

        // Wrap countries
        $countries = new ArrayCollection();
        foreach( $movie['production_countries'] AS $country ) {
            $countries->add( new Data\Country($country) );
        }
        $movie['production_countries'] = $countries;

        // Wrap languages
        $languages = new ArrayCollection();
        foreach( $movie['spoken_languages'] AS $language ) {
            $languages->add( new Data\Language($language) );
        }
        $movie['spoken_languages'] = $languages;

        return new Data\Movie($movie);
    }

    /**
     * Get movie alternative titles
     *
     * @link http://help.themoviedb.org/kb/api/movie-alternative-titles
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @param string $country ISO 3166-1 code
     * @return ArrayCollection
     * @throws Exception\NotFoundException
     */
    public function getAlternativeTitles($movie, $country = null) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $results = $this->get('movie/' . $id . '/alternative_titles', array('country' => $country));

        if(!isset($results['titles'])) throw new Exception\NotFoundException();

        $list = new ArrayCollection();
        foreach($results['titles'] AS $title) {
            $list->add( new Data\Title($title) );
        }

        return $list;
    }

    /**
     * Get movie cast info
     *
     * @link http://help.themoviedb.org/kb/api/movie-casts
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @return Data\Casts
     * @throws Exception\NotFoundException
     */
    public function getCasts($movie) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $casts = $this->get('movie/' . $id . '/casts');

        if(!isset($casts['id'])) throw new Exception\NotFoundException();

        // Wrap Cast
        $list = new ArrayCollection();
        foreach($casts['cast'] AS $cast) {
            $list->add( new Data\Cast($cast) );
        }
        $casts['cast'] = $list;

        // Wrap Crew
        $list = new ArrayCollection();
        foreach($casts['crew'] AS $cast) {
            $list->add( new Data\Crew($cast) );
        }
        $casts['crew'] = $list;

        return new Data\Casts($casts);
    }

    /**
     * Get movie images
     *
     * @link http://help.themoviedb.org/kb/api/movie-images
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @return Data\Images
     * @throws Exception\NotFoundException
     */
    public function getImages($movie) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $images = $this->get('movie/' . $id . '/images');

        if(!isset($images['id'])) throw new Exception\NotFoundException();

        $list = new ArrayCollection();
        foreach($images['backdrops'] AS $backdrop) {
            $list->add( new Data\Backdrop($backdrop) );
        }
        $images['backdrops'] = $list;

        $list = new ArrayCollection();
        foreach($images['posters'] AS $posters) {
            $list->add( new Data\Poster($posters) );
        }
        $images['posters'] = $list;

        return new Data\Images($images);
    }

    /**
     * Get movie keywords
     *
     * @link http://help.themoviedb.org/kb/api/movie-keywords
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @return ArrayCollection
     * @throws Exception\NotFoundException
     */
    public function getKeywords($movie) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $results = $this->get('movie/' . $id . '/keywords');

        if(!isset($results['id'])) throw new Exception\NotFoundException();

        $list = new ArrayCollection();
        foreach($results['keywords'] AS $keyword) {
            $list->set( $keyword['id'], new Data\Keyword($keyword) );
        }
        return $list;
    }

    /**
     * Get movie release and certification data
     *
     * @link http://help.themoviedb.org/kb/api/movie-release-info
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @return ArrayCollection
     * @throws Exception\NotFoundException
     */
    public function getReleases($movie) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $results = $this->get('movie/' . $id . '/releases');

        if(!isset($results['id'])) throw new Exception\NotFoundException();

        $list = new ArrayCollection();
        foreach($results['countries'] AS $keyword) {
            $list->set( $keyword['id'], new Data\Release($keyword) );
        }
        return $list;
    }

    /**
     * Get movie trailers
     *
     * @link http://help.themoviedb.org/kb/api/movie-trailers
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @return Data\Trailers
     * @throws Exception\NotFoundException
     */
    public function getTrailers($movie) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $results = $this->get('movie/' . $id . '/trailers');

        if(!isset($results['id'])) throw new Exception\NotFoundException();

        $list = new ArrayCollection();
        foreach($results['quicktime'] AS $trailer) {
            foreach($trailer['sources'] AS $source) {
                $list->add( new Data\Trailer\QuickTime( array_merge(array('name' => $trailer['name']), $source ) ) );
            }
        }
        $results['quicktime'] = $list;

        $list = new ArrayCollection();
        foreach($results['youtube'] AS $trailer) {
            $list->add( new Data\Trailer\YouTube($trailer) );
        }
        $results['youtube'] = $list;

        return new Data\Trailers($results);
    }

    /**
     * Get movie translations
     *
     * @link http://help.themoviedb.org/kb/api/movie-translations
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @return ArrayCollection
     * @throws Exception\NotFoundException
     */
    public function getTranslations($movie) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $results = $this->get('movie/' . $id . '/translations');

        if(!isset($results['id'])) throw new Exception\NotFoundException();

        $list = new ArrayCollection();
        foreach($results['translations'] AS $translation) {
            $list->add( new Data\Translation($translation) );
        }
        return $list;
    }

    /**
     * Get similar movies
     *
     * @link http://help.themoviedb.org/kb/api/movie-similar-movies
     *
     * @param integer|Data\Movie $movie Movie ID or Object
     * @return PagedCollection
     */
    public function getSimilarMovies($movie) {
        if($movie instanceof Data\Movie) $id = $movie->getId();
        else $id = $movie;

        $self = $this;
        $page_callback = function($page) use($self, $id) {
            $results = $self->get('movie/'.$id.'/similar_movies', array('page' => $page));

            if(!isset($results['results'])) throw new Exception\PageNotFoundException();

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Data\Similar($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

}
