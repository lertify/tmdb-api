<?php

namespace Lertify\TMDb\Api\Data\Company;

use Lertify\TMDb\Api\Data\AbstractData;

class Movie extends AbstractData
{

    public $id;
    public $title;
    public $original_title;
    public $release_date;
    public $backdrop_path;
    public $poster_path;

    public $vote_average;
    public $vote_count;

}

