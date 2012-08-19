<?php

namespace Lertify\TMDb\Api\Data\Collection;

use Lertify\TMDb\Api\Data\AbstractData;

class Poster extends AbstractData
{

    public $file_path;
    public $width;
    public $height;
    public $aspect_ratio;
    public $iso_639_1;
    public $vote_count;
    public $vote_average;

}
