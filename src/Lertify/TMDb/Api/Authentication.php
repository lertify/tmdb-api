<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Exception;
use Lertify\TMDb\Api\Data\Authentication AS Data;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Authentication extends AbstractApi
{

    /**
     * Get configuration data
     *
     * @link http://help.themoviedb.org/kb/api/authentication-request-token
     *
     * @return Data\Token
     * @throws Exception\NotFoundException
     */
    public function getToken() {
        $token = $this->get('authentication/token/new', array(), array('return_header' => true));

        if(!isset($token['success'])) throw new Exception\NotFoundException();

        return new Data\Token($token);
    }

    /**
     * Get a session id for user based authentication
     *
     * @link http://help.themoviedb.org/kb/api/authentication-session-id
     *
     * @param string $request_token Token approved by the user
     * @return Data\Session
     * @throws Exception\NotFoundException
     */
    public function getSession($request_token) {
        $session = $this->get('authentication/session/new', array('request_token' => $request_token));

        var_dump($session);

        if(!isset($session['success'])) throw new Exception\NotFoundException();

        return new Data\Session($session);
    }

}
