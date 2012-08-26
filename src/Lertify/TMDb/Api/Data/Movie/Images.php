<?php

namespace Lertify\TMDb\Api\Data\Movie;

use Lertify\TMDb\Api\Data\AbstractData;

class Images extends AbstractData
{

    public $id;

    /** @var $backdrops \Lertify\TMDb\Api\Data\ArrayCollection */
    public $backdrops;

    /** @var $posters \Lertify\TMDb\Api\Data\ArrayCollection */
    public $posters;

}
