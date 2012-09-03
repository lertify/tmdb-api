<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Exception;

class ConfigurationTest extends \PHPUnit_Framework_TestCase
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
    public function testGetConfiguration()
    {
        $config = $this->object->configuration()->getConfiguration();

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Configuration\Configuration', $config, 'Object is not an instance of Configuration');
        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Configuration\Images', $config->getImages(), 'Object is not an instance of Images');
    }

}
