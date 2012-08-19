<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Exception;

class CollectionsTest extends \PHPUnit_Framework_TestCase
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
        $collection = $this->object->collections()->getInfo(10);
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Collection', $collection, 'Object is not an instance of Collection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $collection->getParts(), 'Parts list is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Part', $collection->getParts()->first(), 'Object is not an instance of Part');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetImages()
    {
        $collection = $this->object->collections()->getInfo(10);

        $list_by_object = $this->object->collections()->getImages($collection);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Images', $list_by_object, 'Object is not an instance of Images, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object->getBackdrops(), 'Collection backdrop list is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_object->getPosters(), 'Collection posters list is not an instance of ArrayCollection, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Backdrop', $list_by_object->getBackdrops()->first(), 'Collection backdrop item is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Poster', $list_by_object->getPosters()->first(), 'Collection poster item is not an instance of ArrayCollection, retrieved by object');

        $list_by_id = $this->object->collections()->getImages(10);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Images', $list_by_id, 'Object is not an instance of Images, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id->getBackdrops(), 'Collection backdrop list is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list_by_id->getPosters(), 'Collection poster list is not an instance of ArrayCollection, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Backdrop', $list_by_id->getBackdrops()->first(), 'Collection backdrop item is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Collection\Poster', $list_by_id->getPosters()->first(), 'Collection poster item is not an instance of ArrayCollection, retrieved by id');

        $this->assertEmpty( array_diff_key( $list_by_object->getBackdrops()->getKeys(), $list_by_id->getBackdrops()->getKeys() ), 'Collection backdrop list retrieved by object and id do not match' );
        $this->assertEmpty( array_diff_key( $list_by_object->getPosters()->getKeys(), $list_by_id->getPosters()->getKeys() ), 'Collection backdrop list retrieved by object and id do not match' );
    }

}
