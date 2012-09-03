<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
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
    public function testFindMovie()
    {
        $list = $this->object->search()->findMovie('Star Wars');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Search\Movie', $list->page(1)->first(), 'List item is not an instance of Movie');

    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testFindMovieByYear()
    {
        $list = $this->object->search()->findMovie('Star Wars', 2005);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Search\Movie', $list->page(1)->first(), 'List item is not an instance of Movie');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testFindMovieAdult()
    {
        $list = $this->object->search()->findMovie('Star Wars', null, true);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Search\Movie', $list->page(1)->first(), 'List item is not an instance of Movie');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testFindPerson()
    {
        $list = $this->object->search()->findPerson('George Lucas');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Search\Person', $list->page(1)->first(), 'List item is not an instance of Movie');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testFindPersonAdult()
    {
        $list = $this->object->search()->findPerson('George Lucas', true);

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Search\Person', $list->page(1)->first(), 'List item is not an instance of Movie');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testFindCompany()
    {
        $list = $this->object->search()->findCompany('Lucasfilm');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\PagedCollection', $list, 'List is not an instance of PagedCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\ArrayCollection', $list->page(1), 'List page is not an instance of ArrayCollection');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Search\Company', $list->page(1)->first(), 'List item is not an instance of Movie');
    }

}
