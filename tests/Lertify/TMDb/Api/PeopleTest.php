<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Exception;

class PeopleTest extends \PHPUnit_Framework_TestCase
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
        $person = $this->object->people()->getInfo(1);
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Person\Person', $person, 'Object is not an instance of Person');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetCredits()
    {
        $person = $this->object->people()->getInfo(1);

        $credits_by_object = $this->object->people()->getCredits( $person );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Person\Credit', $credits_by_object, 'Object is not an instance of Credit, retrieved by object');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $credits_by_object->getCast(), 'Object is not an instance of ArrayCollection, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $credits_by_object->getCrew(), 'Object is not an instance of ArrayCollection, retrieved by object');

        $this->assertFalse( $credits_by_object->getCast()->isEmpty() , 'Credits cast list is empty, retrieved by object' );
        $this->assertFalse( $credits_by_object->getCrew()->isEmpty() , 'Credits crew list is empty, retrieved by object' );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Person\Credit\Cast', $credits_by_object->getCast()->first(), 'Object is not an instance of Cast, retrieved by object');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Person\Credit\Crew', $credits_by_object->getCrew()->first(), 'Object is not an instance of Crew, retrieved by object');

        $credits_by_id = $this->object->people()->getCredits( $person->getId() );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Person\Credit', $credits_by_id, 'Object is not an instance of Credit, retrieved by id');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $credits_by_id->getCast(), 'Object is not an instance of ArrayCollection, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $credits_by_id->getCrew(), 'Object is not an instance of ArrayCollection, retrieved by id');

        $this->assertFalse( $credits_by_id->getCast()->isEmpty() , 'Credits cast list is empty, retrieved by id' );
        $this->assertFalse( $credits_by_id->getCrew()->isEmpty() , 'Credits crew list is empty, retrieved by id' );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Person\Credit\Cast', $credits_by_id->getCast()->first(), 'Object is not an instance of Cast, retrieved by id');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Person\Credit\Crew', $credits_by_id->getCrew()->first(), 'Object is not an instance of Crew, retrieved by id');

        $this->assertEmpty( array_diff_key( $credits_by_object->getCast()->getKeys(), $credits_by_id->getCast()->getKeys() ), 'Credits cast list retrieved by object and id do not match' );
        $this->assertEmpty( array_diff_key( $credits_by_object->getCrew()->getKeys(), $credits_by_id->getCrew()->getKeys() ), 'Credits crew list retrieved by object and id do not match' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetImages()
    {
        $person = $this->object->people()->getInfo(1);

        $images_by_object = $this->object->people()->getImages( $person );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $images_by_object, 'Object is not an instance of ArrayCollection, retrieved by object');

        $images_by_id = $this->object->people()->getImages( $person->getId() );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $images_by_id, 'Object is not an instance of ArrayCollection, retrieved by id');

        $this->assertEmpty( array_diff_key( $images_by_object->getKeys(), $images_by_id->getKeys() ), 'Images list retrieved by object and id do not match' );
    }

}
