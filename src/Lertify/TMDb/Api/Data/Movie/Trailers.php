<?php

namespace Lertify\TMDb\Api\Data\Movie;

use Lertify\TMDb\Api\Data\AbstractData;

class Trailers extends AbstractData
{

    public $id;

    /** @var $quicktime \Lertify\TMDb\Api\Data\ArrayCollection */
    public $quicktime;

    /** @var $youtube \Lertify\TMDb\Api\Data\ArrayCollection */
    public $youtube;

    public function getQuickTime() {
        return $this->quicktime;
    }

    public function getYouTube() {
        return $this->youtube;
    }

}
