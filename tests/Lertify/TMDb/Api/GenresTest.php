<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Lertify\TMDb\Api\Data\Genre;
use Exception;

class SearchTest extends \PHPUnit_Framework_TestCase
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
    public function testAll()
    {
        $list = $this->object->genres()->all();
        foreach($list AS $genre) {
            /** @var $genre Genre */
            echo $genre->name;
            echo $genre->name();
            echo $genre->getName();
            echo $genre->get('name');
        }
    }

}
