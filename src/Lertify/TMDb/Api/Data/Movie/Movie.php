<?php

namespace Lertify\TMDb\Api\Data\Movie;

use Lertify\TMDb\Api\Data\AbstractData;

class Movie extends AbstractData
{

    public $id;
    public $original_title;
    public $title;
    public $overview;
    public $tagline;
    public $release_date;
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
    public $backdrop_path;
    public $poster_path;

    public $vote_average;
    public $vote_count;

}
