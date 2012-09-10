<?php

namespace Lertify\TMDb;

use Lertify\TMDb\Api;
use Lertify\TMDb\Api\ApiInterface;
use Lertify\TMDb\Exception\NotFoundException;
use Lertify\TMDb\Exception\StatusCodeException;

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
            CURLOPT_USERAGENT => 'lertify-tmdb-api',
            CURLOPT_PORT => (isset($options['port']) ? $options['port'] : 80),
            CURLOPT_TIMEOUT => (isset($options['timeout']) ? $options['timeout'] : 10),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => (isset($options['return_header']) ? $options['return_header'] : false),
            CURLOPT_FAILONERROR => false,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'Content-type: application/json'
            ),
        ));

        if( isset($options['post']) ) {
            curl_setopt_array($ch, array(
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => json_encode($options['post'])
            ));
        }

        $response = curl_exec($ch);

        if(curl_errno($ch)) {
            throw new \RuntimeException( curl_error($ch) );
        }

        if( isset($options['return_header']) && $options['return_header'] === true ) {
            $header = substr($response, 0, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
            $response = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));
        }

        $response = json_decode( $response, true );

        if( isset($options['return_header']) && $options['return_header'] === true ) {
            $response['header'] = $this->http_parse_headers($header);
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if( $http_code === 503 ) {
            throw new \RuntimeException( 'Limit exceeded' );
        }

        if( $http_code === 404 ) {
            throw new NotFoundException( (isset($response['status_message']) ? $response['status_message'] : 'Unknown error message') );
        }

        /**
         * Process status codes
         * @link http://help.themoviedb.org/kb/general/api-status-codes
         */
        if( isset($response['status_code']) && $response['status_code'] != 1 && $response['status_code'] != 12 && $response['status_code'] != 13 ) {
            throw new StatusCodeException( $response['status_message'], $response['status_code'] );
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

    /**
     * @return Api\Collections
     */
    public function collections()
    {
        if ( ! isset( $this->apis['collections'] ) )
        {
            $this->apis['collections'] = new Api\Collections( $this );
        }

        return $this->apis['collections'];
    }

    /**
     * @return Api\Movies
     */
    public function movies()
    {
        if ( ! isset( $this->apis['movies'] ) )
        {
            $this->apis['movies'] = new Api\Movies( $this );
        }

        return $this->apis['movies'];
    }

    /**
     * @return Api\Misc
     */
    public function misc()
    {
        if ( ! isset( $this->apis['misc'] ) )
        {
            $this->apis['misc'] = new Api\Misc( $this );
        }

        return $this->apis['misc'];
    }

    /**
     * @return Api\Search
     */
    public function search()
    {
        if ( ! isset( $this->apis['search'] ) )
        {
            $this->apis['search'] = new Api\Search( $this );
        }

        return $this->apis['search'];
    }

    /**
     * @return Api\Configuration
     */
    public function configuration()
    {
        if ( ! isset( $this->apis['configuration'] ) )
        {
            $this->apis['configuration'] = new Api\Configuration( $this );
        }

        return $this->apis['configuration'];
    }

    /**
     * @return Api\Authentication
     */
    public function authentication()
    {
        if ( ! isset( $this->apis['authentication'] ) )
        {
            $this->apis['authentication'] = new Api\Authentication( $this );
        }

        return $this->apis['authentication'];
    }

    /**
     * @return Api\Account
     */
    public function account()
    {
        if ( ! isset( $this->apis['account'] ) )
        {
            $this->apis['account'] = new Api\Account( $this );
        }

        return $this->apis['account'];
    }

    /**
     * Parses HTTP headers and request/status lines into an associative array.
     *
     * @author  Anonymous
     * @author  Aldo Fregoso C.
     * @license Public Domain
     *
     * @param string $header string containing HTTP headers.
     *
     * @return array Parsed headers with request/status lines using RFC2616's field names.
     */
    private function http_parse_headers( $header )
    {
        $values = array ();
        $fields = explode( "\r\n", preg_replace( '/\x0D\x0A[\x09\x20]+/', ' ', $header ) );
        foreach ( $fields as $field )
        {
            if ( preg_match( '/([^:]+):(.+)/m', $field, $match ) )
            {
                $match[1] = preg_replace( '/(?<=^|[\x09\x20\x2D])./e', 'strtoupper("\0")', strtolower( trim( $match[1] ) ) );
                $match[2] = trim( $match[2] );

                if ( isset($values[$match[1]]) )
                {
                    if ( is_array( $values[$match[1]] ) )
                    {
                        $values[$match[1]][] = $match[2];
                    } else {
                        $values[$match[1]] = array ( $values[$match[1]], $match[2] );
                    }
                } else {
                    $values[$match[1]] = $match[2];
                }
            } else if ( preg_match( '/([A-Za-z]+) (.*) HTTP\/([\d.]+)/', $field, $match ) ) {
                $values["Request-Line"] = array (
                    "Method"       => $match[1],
                    "Request-URI"  => $match[2],
                    "HTTP-Version" => $match[3]
                );
            } else if ( preg_match( '/HTTP\/([\d.]+) (\d+) (.*)/', $field, $match ) ) {
                $values["Status-Line"] = array (
                    "HTTP-Version"  => $match[1],
                    "Status-Code"   => $match[2],
                    "Reason-Phrase" => $match[3]
                );
            }
        }
        return $values;
    }

}
