<?php

namespace Lertify\TMDb\Api\Data\Movie;

use Lertify\TMDb\Api\Data\AbstractData;

class Casts extends AbstractData
{

    public $id;

    /** @var $cast \Lertify\TMDb\Api\Data\ArrayCollection */
    public $cast;

    /** @var $crew \Lertify\TMDb\Api\Data\ArrayCollection */
    public $crew;

}
