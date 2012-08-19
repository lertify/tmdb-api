<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Exception;

class GenresTest extends \PHPUnit_Framework_TestCase
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
    public function testGetList()
    {
        $list = $this->object->genres()->getList();

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list, 'Genres list is not a array collection');

        $this->assertFalse( $list->isEmpty() , 'Genres list is empty' );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Genre\Genre', $list->first());
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetMovies()
    {
        $list = $this->object->genres()->getList();

        $genre = $list->first();

        $list_by_object = $this->object->genres()->getMovies( $genre );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_object, 'Genre movies list is not a paged collection, retrieved by object');

        $this->assertFalse( $list_by_object->isEmpty() , 'Genre movies list is empty, retrieved by object' );

        $list_by_id = $this->object->genres()->getMovies( $genre->getId() );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_id, 'Genre movies list is not a paged collection, retrieved by id');

        $this->assertFalse( $list_by_id->isEmpty() , 'Genre movies list is empty, retrieved by id' );

        $this->assertEmpty( array_diff_key( $list_by_object->page(1)->getKeys(), $list_by_id->page(1)->getKeys() ), 'Genre movies list retrieved by object and id do not match' );
    }

}
