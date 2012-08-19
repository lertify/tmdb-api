<?php

namespace Lertify\TMDb;

use Lertify\TMDb\Api;
use Lertify\TMDb\Api\ApiInterface;
use Lertify\TMDb\Exception\NotFoundException;

class Client
{

    /**
     * @var string
     */
    private $api_url = 'http://api.themoviedb.org/3/';

    /**
     * @var string
     */
    private $api_key;

    /**
     * The list of loaded API instances
     *
     * @var array
     */
    private $apis = array();

    /**
     * @param string $apiKey
     */
    public function __construct( $api_key )
    {
        $this->api_key = $api_key;
    }

    /**
     * @return string
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->api_key;
    }

    public function get($path, array $parameters = array(), $options = array()) {
        $ch = curl_init();

        $default_parameters = array(
            'api_key' => $this->getApiKey()
            , 'langauge' => 'en'
        );
        $parameters = array_merge($default_parameters, $parameters);

        $query = http_build_query($parameters);

        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->getApiUrl().$path.'?'.$query,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FAILONERROR => false,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-type: application/json'
            ),
        ));

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new \RuntimeException( curl_error($ch) );
        }

        $response = json_decode( $response, true );

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if( $http_code === 404 ) {
            throw new NotFoundException( (isset($response['status_message']) ? $response['status_message'] : 'Unknown error message') );
        }

        return $response;
    }

    /**
     * @return Api\Genres
     */
    public function genres()
    {
        if ( ! isset( $this->apis['genres'] ) )
        {
            $this->apis['genres'] = new Api\Genres( $this );
        }

        return $this->apis['genres'];
    }

    /**
     * @return Api\Companies
     */
    public function companies()
    {
        if ( ! isset( $this->apis['companies'] ) )
        {
            $this->apis['companies'] = new Api\Companies( $this );
        }

        return $this->apis['companies'];
    }

    /**
     * @return Api\People
     */
    public function people()
    {
        if ( ! isset( $this->apis['people'] ) )
        {
            $this->apis['people'] = new Api\People( $this );
        }

        return $this->apis['people'];
    }

}
