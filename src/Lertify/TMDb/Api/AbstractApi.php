<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Client;

abstract class AbstractApi implements ApiInterface
{

    /**
     * The client
     *
     * @var Client
     */
    protected $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritDoc}
     */
    public function get($path, array $parameters = array(), $requestOptions = array())
    {
        return $this->client->get($path, $parameters, $requestOptions);
    }

}
