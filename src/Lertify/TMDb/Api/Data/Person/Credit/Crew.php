<?php

namespace Lertify\TMDb\Api\Data\Person\Credit;

use Lertify\TMDb\Api\Data\AbstractData;

class Crew extends AbstractData
{

    public $id;
    public $title;
    public $original_title;
    public $job;
    public $department;
    public $adult;
    public $release_date;
    public $poster_path;

}