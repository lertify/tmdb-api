<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Api\Data\Collection\Collection;
use Lertify\TMDb\Api\Data\Collection\Part;
use Lertify\TMDb\Api\Data\Collection\Images;
use Lertify\TMDb\Api\Data\Collection\Backdrop;
use Lertify\TMDb\Api\Data\Collection\Poster;
use Lertify\TMDb\Api\Data\ArrayCollection;

class Collections extends AbstractApi
{

    /**
     * Get collection info
     *
     * @link http://help.themoviedb.org/kb/api/collection-info
     *
     * @param integer $id ID of the collection
     * @return Collection|null
     */
    public function getInfo( $id ) {
        $collection = $this->get('collection/' . $id);

        if(!isset($collection['id'])) return null;

        $list = new ArrayCollection();
        foreach($collection['parts'] AS $part) {
            $list->set( $part['id'] , new Part($part) );
        }
        $collection['parts'] = $list;

        return new Collection($collection);
    }

    /**
     * Get collection images
     *
     * @link http://help.themoviedb.org/kb/api/collection-images
     *
     * @param Collection|integer $collection ID of the collection
     * @return Images|null
     */
    public function getImages( $collection ) {
        if($collection instanceof Collection) $id = $collection->getId();
        else $id = $collection;

        $images = $this->get('collection/' . $id . '/images');

        if(!isset($images['id'])) return null;

        $list = new ArrayCollection();
        foreach($images['backdrops'] AS $backdrop) {
            $list->add( new Backdrop($backdrop) );
        }
        $images['backdrops'] = $list;

        $list = new ArrayCollection();
        foreach($images['posters'] AS $posters) {
            $list->add( new Poster($posters) );
        }
        $images['posters'] = $list;

        return new Images($images);
    }

}
