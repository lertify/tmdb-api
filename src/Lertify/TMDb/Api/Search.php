<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Exception;
use Lertify\TMDb\Api\Data\Search AS Data;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Search extends AbstractApi
{

    /**
     * Find movies on TMDb
     *
     * @link http://help.themoviedb.org/kb/api/search-movies
     *
     * @param string $query search text
     * @param integer|null $year Movie release year
     * @param bool $include_adult Include adult items
     * @return Data\PagedCollection
     * @throws Exception\PageNotFoundException
     */
    public function findMovie($query, $year = null, $include_adult = false) {
        $self = $this;
        $page_callback = function($page) use ($self, $query, $year, $include_adult) {
            $results = $self->get('search/movie', array('query' => $query, 'page' => $page, 'year' => $year, 'include_adult' => $include_adult));

            if(!isset($results['results'])) throw new Exception\PageNotFoundException();

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Data\Movie($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

    /**
     * Find people on TMDb
     *
     * @link http://help.themoviedb.org/kb/api/search-people
     *
     * @param string $query search text
     * @param bool $include_adult Include adult items
     * @return Data\PagedCollection
     * @throws Exception\PageNotFoundException
     */
    public function findPerson($query, $include_adult = false) {
        $self = $this;
        $page_callback = function($page) use ($self, $query, $include_adult) {
            $results = $self->get('search/person', array('query' => $query, 'page' => $page, 'include_adult' => $include_adult));

            if(!isset($results['results'])) throw new Exception\PageNotFoundException();

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Data\Person($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

    /**
     * Find company on TMDb
     *
     * @link http://help.themoviedb.org/kb/api/search-companies
     *
     * @param string $query search text
     * @param bool $include_adult Include adult items
     * @return Data\PagedCollection
     * @throws Exception\PageNotFoundException
     */
    public function findCompany($query) {
        $self = $this;
        $page_callback = function($page) use ($self, $query) {
            $results = $self->get('search/company', array('query' => $query, 'page' => $page));

            if(!isset($results['results'])) throw new Exception\PageNotFoundException();

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Data\Company($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }



}
