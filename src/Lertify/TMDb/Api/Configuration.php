<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Exception;
use Lertify\TMDb\Api\Data\Configuration AS Data;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Configuration extends AbstractApi
{

    /**
     * Get configuration data
     *
     * @link http://help.themoviedb.org/kb/api/configuration
     *
     * @return Data\Configuration
     * @throws Exception\NotFoundException
     */
    public function getConfiguration() {
        $configuration = $this->get('configuration');

        if(!isset($configuration['images'])) throw new Exception\NotFoundException();

        $configuration['images'] = new Data\Images($configuration['images']);

        return new Data\Configuration($configuration);
    }

}
