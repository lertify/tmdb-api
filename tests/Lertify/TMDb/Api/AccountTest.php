<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Api\Data\Authentication\Session;
use Lertify\TMDb\Api\Data\Movie\ShortInfo AS Movie;
use Lertify\TMDb\Client;
use Exception;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Client
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Client( $GLOBALS['api_key'] );
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetInfo()
    {
        $session_id = $GLOBALS['session_id'];

        $account = $this->object->account()->getInfo( $session_id );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Account\Account', $account, 'Object is not an instance of Account, retrieved by id');

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Account\Account', $account, 'Object is not an instance of Account, retrieved by object');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetFavoriteMovies()
    {
        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session_id );

        $account_id = $account->getId();

        $list_by_object = $this->object->account()->getFavoriteMovies( $session, $account );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_object, 'Favorite movies list is not a paged collection, retrieved by object');

        $this->assertFalse( $list_by_object->isEmpty() , 'Favorite movies list is empty, retrieved by object' );

        $list_by_id = $this->object->account()->getFavoriteMovies( $session_id, $account_id );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_id, 'Favorite movies list is not a paged collection, retrieved by id');

        $this->assertFalse( $list_by_id->isEmpty() , 'Favorite movies list is empty, retrieved by id' );

        $this->assertEmpty( array_diff_key( $list_by_object->page(1)->getKeys(), $list_by_id->page(1)->getKeys() ), 'Favorite movies list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetRatedMovies()
    {
        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session_id );

        $account_id = $account->getId();

        $list_by_object = $this->object->account()->getRatedMovies( $session, $account );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_object, 'Rated movies list is not a paged collection, retrieved by object');

        $this->assertFalse( $list_by_object->isEmpty() , 'Rated movies list is empty, retrieved by object' );

        $list_by_id = $this->object->account()->getRatedMovies( $session_id, $account_id );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_id, 'Rated movies list is not a paged collection, retrieved by id');

        $this->assertFalse( $list_by_id->isEmpty() , 'Rated movies list is empty, retrieved by id' );

        $this->assertEmpty( array_diff_key( $list_by_object->page(1)->getKeys(), $list_by_id->page(1)->getKeys() ), 'Rated movies list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetMovieWatchlist()
    {
        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session_id );

        $account_id = $account->getId();

        $list_by_object = $this->object->account()->getMovieWatchlist( $session, $account );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_object, 'Watchlist movies list is not a paged collection, retrieved by object');

        $this->assertFalse( $list_by_object->isEmpty() , 'Watchlist movies list is empty, retrieved by object' );

        $list_by_id = $this->object->account()->getMovieWatchlist( $session_id, $account_id );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_id, 'Watchlist movies list is not a paged collection, retrieved by id');

        $this->assertFalse( $list_by_id->isEmpty() , 'Watchlist movies list is empty, retrieved by id' );

        $this->assertEmpty( array_diff_key( $list_by_object->page(1)->getKeys(), $list_by_id->page(1)->getKeys() ), 'Watchlist movies list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testAddToFavorites()
    {
        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session_id );

        $account_id = $account->getId();

        $movie_id = 1891;

        $movie = new Movie(array('id' => $movie_id));

        $this->object->account()->addToFavorites( $session, $account, $movie );

        $movie_id = 1892;

        $this->object->account()->addToFavorites( $session_id, $account_id, $movie_id );

        $movie_id = 1893;

        $this->object->account()->addToFavorites( $session_id, $account_id, $movie_id );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testRemoveFromFavorites()
    {
        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session_id );

        $account_id = $account->getId();

        $movie_id = 1892;

        $movie = new Movie(array('id' => $movie_id));

        $this->object->account()->removeFromFavorites( $session, $account, $movie );

        $movie_id = 1893;

        $this->object->account()->removeFromFavorites( $session_id, $account_id, $movie_id );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testAddToWatchlist()
    {
        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session_id );

        $account_id = $account->getId();

        $movie_id = 1891;

        $movie = new Movie(array('id' => $movie_id));

        $this->object->account()->addToWatchlist( $session, $account, $movie );

        $movie_id = 1892;

        $this->object->account()->addToWatchlist( $session_id, $account_id, $movie_id );

        $movie_id = 1893;

        $this->object->account()->addToWatchlist( $session_id, $account_id, $movie_id );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testRemoveFromWatchlist()
    {
        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $account = $this->object->account()->getInfo( $session_id );

        $account_id = $account->getId();

        $movie_id = 1892;

        $movie = new Movie(array('id' => $movie_id));

        $this->object->account()->removeFromWatchlist( $session, $account, $movie );

        $movie_id = 1893;

        $this->object->account()->removeFromWatchlist( $session_id, $account_id, $movie_id );
    }

}
