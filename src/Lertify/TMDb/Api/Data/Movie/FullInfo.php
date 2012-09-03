<?php

namespace Lertify\TMDb\Api\Data\Movie;

use Lertify\TMDb\Api\Data\Movie\ShortInfo;

class FullInfo extends ShortInfo
{

    public $overview;
    public $tagline;

    public $genres;
    public $adult;
    public $homepage;
    public $runtime;
    public $budget;
    public $revenue;
    public $production_companies;
    public $production_countries;
    public $spoken_languages;
    public $belongs_to_collection;

    public $popularity;
    public $imdb_id;

}
