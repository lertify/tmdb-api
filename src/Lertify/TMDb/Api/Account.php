<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Exception;
use Lertify\TMDb\Api\Data\Account AS Data;
use Lertify\TMDb\Api\Data\Movie AS MovieData;
use Lertify\TMDb\Api\Data\Authentication\Session;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Account extends AbstractApi
{

    /**
     * Get account info
     *
     * @link http://help.themoviedb.org/kb/api/account-info
     *
     * @param string|Session $session Session id or object
     * @throws \Lertify\TMDb\Exception\NotFoundException
     * @return Data\Account
     */
    public function getInfo( $session ) {

        if( $session instanceof Session ) $id = $session->getSessionId();
        else $id = $session;

        $info = $this->get('account', array('session_id' => $id));

        if(!isset($info['id'])) throw new Exception\NotFoundException();

        return new Data\Account($info);
    }

    /**
     * Get favorite movies
     *
     * @link http://help.themoviedb.org/kb/api/account-favorite-movies
     *
     * @param string|Session $session Session id or object
     * @param integer|Data\Account $account Account id or object
     * @return Data\PagedCollection
     */
    public function getFavoriteMovies( $session, $account ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $account instanceof Data\Account ) $account_id = $account->getId();
        else $account_id = $account;

        $self = $this;
        $page_callback = function($page) use($self, $session_id, $account_id) {
            $results = $self->get('account/'.$account_id.'/favorite_movies', array('session_id' => $session_id, 'page' => $page));

            if(!isset($results['results'])) return null;

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Data\Favorite\Movie($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

    /**
     * Get rated movies
     *
     * @link http://help.themoviedb.org/kb/api/account-rated-movies
     *
     * @param string|Session $session Session id or object
     * @param integer|Data\Account $account Account id or object
     * @return Data\PagedCollection
     */
    public function getRatedMovies( $session, $account ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $account instanceof Data\Account ) $account_id = $account->getId();
        else $account_id = $account;

        $self = $this;
        $page_callback = function($page) use($self, $session_id, $account_id) {
            $results = $self->get('account/'.$account_id.'/favorite_movies', array('session_id' => $session_id, 'page' => $page));

            if(!isset($results['results'])) return null;

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Data\Rated\Movie($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

    /**
     * Get watchlist
     *
     * @link http://help.themoviedb.org/kb/api/account-movie-watchlist-2
     *
     * @param string|Session $session Session id or object
     * @param integer|Data\Account $account Account id or object
     * @return Data\PagedCollection
     */
    public function getMovieWatchlist( $session, $account ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $account instanceof Data\Account ) $account_id = $account->getId();
        else $account_id = $account;

        $self = $this;
        $page_callback = function($page) use($self, $session_id, $account_id) {
            $results = $self->get('account/'.$account_id.'/movie_watchlist', array('session_id' => $session_id, 'page' => $page));

            if(!isset($results['results'])) return null;

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Data\Watchlist\Movie($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

    /**
     * Add movie to favorites
     *
     * @link http://help.themoviedb.org/kb/api/account-add-favorite
     *
     * @param string|Session $session Session id or object
     * @param integer|Data\Account $account Account id or object
     * @param integer|MovieData\ShortInfo $movie Movie id or object
     * @return bool
     */
    public function addToFavorites( $session, $account, $movie ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $account instanceof Data\Account ) $account_id = $account->getId();
        else $account_id = $account;

        if( $movie instanceof MovieData\ShortInfo ) $movie_id = $movie->getId();
        else $movie_id = $movie;

        $this->get('account/'.$account_id.'/favorite'
            , array(
                'session_id' => $session_id
            ), array(
                'post' => array(
                    'movie_id' => $movie_id
                    , 'favorite' => true
                )
            )
        );

        return true;
    }

    /**
     * Remove movie from favorites
     *
     * @link http://help.themoviedb.org/kb/api/account-add-favorite
     *
     * @param string|Session $session Session id or object
     * @param integer|Data\Account $account Account id or object
     * @param integer|MovieData\ShortInfo $movie Movie id or object
     * @return bool
     */
    public function removeFromFavorites( $session, $account, $movie ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $account instanceof Data\Account ) $account_id = $account->getId();
        else $account_id = $account;

        if( $movie instanceof MovieData\ShortInfo ) $movie_id = $movie->getId();
        else $movie_id = $movie;

        $this->get('account/'.$account_id.'/favorite'
            , array(
                'session_id' => $session_id
            ), array(
                'post' => array(
                    'movie_id' => $movie_id
                    , 'favorite' => false
                )
            )
        );

        return true;
    }

    /**
     * Add movie to watchlist
     *
     * @link http://help.themoviedb.org/kb/api/account-add-movie-watchlist
     *
     * @param string|Session $session Session id or object
     * @param integer|Data\Account $account Account id or object
     * @param integer|MovieData\ShortInfo $movie Movie id or object
     * @return bool
     */
    public function addToWatchlist( $session, $account, $movie ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $account instanceof Data\Account ) $account_id = $account->getId();
        else $account_id = $account;

        if( $movie instanceof MovieData\ShortInfo ) $movie_id = $movie->getId();
        else $movie_id = $movie;

        $this->get('account/'.$account_id.'/movie_watchlist'
            , array(
                'session_id' => $session_id
            ), array(
                'post' => array(
                    'movie_id' => $movie_id
                    , 'movie_watchlist' => true
                )
            )
        );

        return true;
    }

    /**
     * Remove movie from watchlist
     *
     * @link http://help.themoviedb.org/kb/api/account-add-movie-watchlist
     *
     * @param string|Session $session Session id or object
     * @param integer|Data\Account $account Account id or object
     * @param integer|MovieData\ShortInfo $movie Movie id or object
     * @return bool
     */
    public function removeFromWatchlist( $session, $account, $movie ) {
        if( $session instanceof Session ) $session_id = $session->getSessionId();
        else $session_id = $session;

        if( $account instanceof Data\Account ) $account_id = $account->getId();
        else $account_id = $account;

        if( $movie instanceof MovieData\ShortInfo ) $movie_id = $movie->getId();
        else $movie_id = $movie;

        $this->get('account/'.$account_id.'/movie_watchlist'
            , array(
                'session_id' => $session_id
            ), array(
                'post' => array(
                    'movie_id' => $movie_id
                    , 'movie_watchlist' => false
                )
            )
        );

        return true;
    }

}
