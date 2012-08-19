<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Api\Data\Genre\Genre;
use Lertify\TMDb\Api\Data\Genre\Movie;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Genres extends AbstractApi
{

    /**
     * Get list of genres
     *
     * @link http://help.themoviedb.org/kb/api/genre-list
     * @return ArrayCollection
     */
    public function all() {
        $results = $this->get('genre/list');

        $list = new ArrayCollection();

        if(!isset($results['genres'])) return $list;

        foreach($results['genres'] AS $genre) {
            $list->set( $genre['id'] , new Genre($genre) );
        }

        return $list;
    }


    /**
     * Get a list of movies per genre
     *
     * @link http://help.themoviedb.org/kb/api/genre-movies
     *
     * @param Genre|integer $genre ID of the genre
     * @return PagedCollection|null
     */
    public function movies($genre) {

        if($genre instanceof Genre) $id = $genre->getId();
        else $id = $genre;

        $self = $this;
        $page_callback = function($page) use($self, $id) {
            $results = $self->get('genre/'.$id.'/movies', array('page' => $page));

            if(!isset($results['results'])) return null;

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Movie($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

}
