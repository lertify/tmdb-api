<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Api\Data\Genre;

class Genres extends AbstractApi
{

    public function all() {
        $results = $this->client->get('genre/list');
        $list = array();

        if(!isset($results['genres'])) return $list;

        foreach($results['genres'] AS $genre) {
            $list[ $genre['id'] ] = new Genre($genre);
        }

        return $list;
    }

    public function get() {

    }

}
