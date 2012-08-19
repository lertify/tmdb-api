<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Exception;

class CompaniesTest extends \PHPUnit_Framework_TestCase
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
    public function testInfo()
    {
        $company = $this->object->companies()->info(1);
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Company\Company', $company, 'Object is not an instance of Company');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testMovies()
    {
        $list_by_object = $this->object->companies()->movies( 1 );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_object, 'Company movies list is not a paged collection, retrieved by object');

        $this->assertFalse( $list_by_object->isEmpty() , 'Company movies list is empty, retrieved by object' );

        $list_by_id = $this->object->companies()->movies( 1 );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list_by_id, 'Company movies list is not a paged collection, retrieved by id');

        $this->assertFalse( $list_by_id->isEmpty() , 'Company movies list is empty, retrieved by id' );

        $this->assertEmpty( array_diff_key( $list_by_object->page(1)->getKeys(), $list_by_id->page(1)->getKeys() ), 'Company movies list retrieved by object and id do not match' );
    }

}
