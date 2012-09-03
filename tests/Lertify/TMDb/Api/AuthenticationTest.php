<?php

namespace Lertify\TMDb\Tests\Api;

use Lertify\TMDb\Client;
use Exception;

class AuthenticationTest extends \PHPUnit_Framework_TestCase
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
    public function testGetToken()
    {
        $token = $this->object->authentication()->getToken();

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Authentication\Token', $token, 'Object is not an instance of Token');
        $this->assertNotNull( $token->getAuthenticationCallback(), 'Authentication callback url not found' );
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetSessionInvalidToken()
    {
        $session = $this->object->authentication()->getSession('XXXXX');

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Authentication\Session', $session, 'Object is not an instance of Session');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetSessionUnApprovedToken()
    {

        $token = $this->object->authentication()->getToken();

        $session = $this->object->authentication()->getSession( $token->getRequestToken() );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Authentication\Session', $session, 'Object is not an instance of Session');
    }

    /**
     * @covers {className}::{origMethodName}
     */
    public function testGetSessionApprovedToken()
    {
        $session = $this->object->authentication()->getSession( $GLOBALS['request_token'] );

        $this->assertInstanceOf('Lertify\TMDb\Api\Data\Authentication\Session', $session, 'Object is not an instance of Session');
    }

}
