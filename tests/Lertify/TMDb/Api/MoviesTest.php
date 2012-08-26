<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Exception;

class MoviesTest extends \PHPUnit_Framework_TestCase
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
        $movie = $this->object->movies()->getInfo(11);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Movie', $movie, 'Object is not an instance of Movie');

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
    public function testGetAlternativeTitles()
    {
        $id = 11;

        $movie = $this->object->movies()->getInfo($id);

        $titles_by_object = $this->object->movies()->getAlternativeTitles($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $titles_by_object, 'Object is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Title', $titles_by_object->first(), 'Object is not an instance of Title, retrieved by object');

        $titles_by_id = $this->object->movies()->getAlternativeTitles($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $titles_by_id, 'Object is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Title', $titles_by_id->first(), 'Object is not an instance of Title, retrieved by id');

        $this->assertEmpty( array_diff_key( $titles_by_object->getKeys(), $titles_by_id->getKeys() ), 'Movie titles list retrieved by object and id do not match' );

        $titles_for_country = $this->object->movies()->getAlternativeTitles($id, 'US');

        $this->assertEquals('US', $titles_for_country->first()->iso_3166_1, 'Incorrect alternative title country');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetCasts()
    {
        $id = 11;

        $movie = $this->object->movies()->getInfo($id);

        $casts_by_object = $this->object->movies()->getCasts($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Casts', $casts_by_object, 'Object is not an instance of Casts, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $casts_by_object->getCast(), 'Cast list is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Cast', $casts_by_object->getCast()->first(), 'Object is not an instance of Cast, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $casts_by_object->getCrew(), 'Crew list is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Crew', $casts_by_object->getCrew()->first(), 'Object is not an instance of Crew, retrieved by object');

        $casts_by_id = $this->object->movies()->getCasts($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Casts', $casts_by_id, 'Object is not an instance of Casts, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $casts_by_id->getCast(), 'Cast list is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Cast', $casts_by_id->getCast()->first(), 'Object is not an instance of Cast, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $casts_by_id->getCrew(), 'Crew list is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Crew', $casts_by_id->getCrew()->first(), 'Object is not an instance of Crew, retrieved by id');

        $this->assertEmpty( array_diff_key( $casts_by_object->getCast()->getKeys(), $casts_by_id->getCast()->getKeys() ), 'Movie cast list retrieved by object and id do not match' );
        $this->assertEmpty( array_diff_key( $casts_by_object->getCrew()->getKeys(), $casts_by_id->getCrew()->getKeys() ), 'Movie crew list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetImages()
    {
        $id = 11;

        $movie = $this->object->movies()->getInfo($id);

        $list_by_object = $this->object->movies()->getImages($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Images', $list_by_object, 'Object is not an instance of Images, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object->getBackdrops(), 'Movie backdrop list is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Backdrop', $list_by_object->getBackdrops()->first(), 'Movie backdrop item is not an instance of Backdrop, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object->getPosters(), 'Movie posters list is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Poster', $list_by_object->getPosters()->first(), 'Movie poster item is not an instance of Poster, retrieved by object');

        $list_by_id = $this->object->movies()->getImages($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Images', $list_by_id, 'Object is not an instance of Images, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id->getBackdrops(), 'Movie backdrop list is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Backdrop', $list_by_id->getBackdrops()->first(), 'Movie backdrop item is not an instance of Backdrop, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id->getPosters(), 'Movie poster list is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Poster', $list_by_id->getPosters()->first(), 'Movie poster item is not an instance of Poster, retrieved by id');

        $this->assertEmpty( array_diff_key( $list_by_object->getBackdrops()->getKeys(), $list_by_id->getBackdrops()->getKeys() ), 'Movie backdrop list retrieved by object and id do not match' );
        $this->assertEmpty( array_diff_key( $list_by_object->getPosters()->getKeys(), $list_by_id->getPosters()->getKeys() ), 'Movie backdrop list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetKeywords()
    {
        $id = 11;

        $movie = $this->object->movies()->getInfo($id);

        $list_by_object = $this->object->movies()->getKeywords($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object, 'Object is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Keyword', $list_by_object->first(), 'Object is not an instance of Keyword, retrieved by object');

        $list_by_id = $this->object->movies()->getKeywords($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id, 'Object is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Keyword', $list_by_id->first(), 'Object is not an instance of Keyword, retrieved by id');

        $this->assertEmpty( array_diff_key( $list_by_object->getKeys(), $list_by_id->getKeys() ), 'Movie keywords list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetReleases()
    {
        $id = 11;

        $movie = $this->object->movies()->getInfo($id);

        $list_by_object = $this->object->movies()->getReleases($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object, 'Object is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Release', $list_by_object->first(), 'Object is not an instance of Release, retrieved by object');

        $list_by_id = $this->object->movies()->getReleases($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id, 'Object is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Release', $list_by_id->first(), 'Object is not an instance of Release, retrieved by id');

        $this->assertEmpty( array_diff_key( $list_by_object->getKeys(), $list_by_id->getKeys() ), 'Movie keywords list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetTrailers()
    {
        $id = 49026;

        $movie = $this->object->movies()->getInfo($id);

        $list_by_object = $this->object->movies()->getTrailers($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Trailers', $list_by_object, 'Object is not an instance of Trailers, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object->getQuickTime(), 'QuickTime trailers list is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Trailer\QuickTime', $list_by_object->getQuickTime()->first(), 'QuickTime trailer is not an instance of QuickTime, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object->getYouTube(), 'YouTube trailers list is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Trailer\YouTube', $list_by_object->getYouTube()->first(), 'YouTube trailer is not an instance of YouTube, retrieved by object');

        $list_by_id = $this->object->movies()->getTrailers($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Trailers', $list_by_id, 'Object is not an instance of Trailers, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id->getQuickTime(), 'QuickTime trailers list is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Trailer\QuickTime', $list_by_id->getQuickTime()->first(), 'QuickTime trailer is not an instance of QuickTime, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id->getYouTube(), 'YouTube trailers list is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Trailer\YouTube', $list_by_id->getYouTube()->first(), 'YouTube trailer is not an instance of YouTube, retrieved by id');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetTranslations()
    {
        $id = 11;

        $movie = $this->object->movies()->getInfo($id);

        $list_by_object = $this->object->movies()->getTranslations($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object, 'List is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Translation', $list_by_object->first(), 'List item is not an instance of Translation, retrieved by object');

        $list_by_id = $this->object->movies()->getTranslations($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id, 'List is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Translation', $list_by_id->first(), 'List item is not an instance of Translation, retrieved by id');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetSimilarMovies()
    {
        $id = 11;

        $movie = $this->object->movies()->getInfo($id);

        $list_by_object = $this->object->movies()->getSimilarMovies($movie);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_object, 'List is not an instance of PagedCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object->page(1), 'List page is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Similar', $list_by_object->page(1)->first(), 'List item is not an instance of Similar, retrieved by object');

        $list_by_id = $this->object->movies()->getSimilarMovies($id);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_id, 'List is not an instance of PagedCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id->page(1), 'List page is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Movie\Similar', $list_by_id->page(1)->first(), 'List item is not an instance of Similar, retrieved by id');
    }

}
