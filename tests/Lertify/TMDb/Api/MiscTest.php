<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Api\Data\Authentication\Session;
use Lertify\TMDb\Api\Data\Movie\ShortInfo AS Movie;
use Lertify\TMDb\Client;
use Exception;

class MiscTest extends \PHPUnit_Framework_TestCase
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
    public function testGetLatestMovie()
    {
        $movie = $this->object->misc()->getLatestMovie();

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Misc\Movie', $movie, 'Object is not an instance of Movie');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $movie->getGenres(), 'Genres are not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Genre', $movie->getGenres()->first(), 'Object is not an instance of Genre');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $movie->getProductionCompanies(), 'Production companies are not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Company', $movie->getProductionCompanies()->first(), 'Object is not an instance of Company');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $movie->getProductionCountries(), 'Production countries is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Country', $movie->getProductionCountries()->first(), 'Object is not an instance of Country');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $movie->getSpokenLanguages(), 'Spoken languages are not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Language', $movie->getSpokenLanguages()->first(), 'Object is not an instance of Language');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Collection', $movie->getBelongsToCollection(), 'Object is not an instance of Collection');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetNowPlaying()
    {
        $list = $this->object->misc()->getNowPlaying();

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Misc\NowPlaying', $list->page(1)->first(), 'List item is not an instance of NowPlaying');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetPopular()
    {
        $list = $this->object->misc()->getPopular();

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Misc\Popular', $list->page(1)->first(), 'List item is not an instance of Popular');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetTopRated()
    {
        $list = $this->object->misc()->getTopRated();

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Misc\TopRated', $list->page(1)->first(), 'List item is not an instance of TopRated');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testAddRating()
    {

        $session_id = $GLOBALS['session_id'];

        $session = new Session(array('session_id' => $session_id));

        $movie_id = 1891;

        $movie = new Movie(array('id' => $movie_id));

        $res = $this->object->misc()->addRating( $session, $movie, 10 );

        $movie_id = 1892;

        $this->object->misc()->addRating( $session_id, $movie_id, 10 );

        $movie_id = 1892;

        $result = false;
        try {
            $this->object->misc()->addRating( $session_id, $movie_id, 15 );
            $result = true;
        } catch(\InvalidArgumentException $e) {

        }

        $this->assertFalse($result, 'Exceptions should be thrown on incorrect rating value');
    }

}
