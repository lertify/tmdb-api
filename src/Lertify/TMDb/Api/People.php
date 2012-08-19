<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Api\Data\Person\Person;
use Lertify\TMDb\Api\Data\Person\Credit;
use Lertify\TMDb\Api\Data\Person\Credit\Cast;
use Lertify\TMDb\Api\Data\Person\Credit\Crew;
use Lertify\TMDb\Api\Data\Person\Image;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class People extends AbstractApi
{
    /**
     * Get person info by ID
     *
     * @link http://help.themoviedb.org/kb/api/person-info
     *
     * @param integer $id ID of the person
     * @return Person
     */
    public function getInfo( $id ) {
       $person = $this->get('person/' . $id);
       return new Person($person);
    }

    /**
     * Get person credits by ID or Person
     * @param Person|integer $person ID of the person
     * @return Person\Credit|null
     */
    public function getCredits( $person ) {
        if($person instanceof Person) $id = $person->getId();
        else $id = $person;

        $credits = $this->get('person/' . $id . '/credits');

        if(!isset($credits['id'])) return null;

        $list = new ArrayCollection();
        foreach($credits['cast'] AS $cast) {
            $list->set( $cast['id'] , new Cast($cast) );
        }
        $credits['cast'] = $list;

        $list = new ArrayCollection();
        foreach($credits['crew'] AS $crew) {
            $list->set( $crew['id'] , new Crew($crew) );
        }
        $credits['crew'] = $list;

        return new Credit( $credits );
    }

    /**
     * Get person profile images
     * @param Person|integer $person ID of the person
     * @return ArrayCollection|null
     */
    public function getImages( $person ) {
        if($person instanceof Person) $id = $person->getId();
        else $id = $person;

        $images = $this->get('person/' . $id . '/images');

        if(!isset($images['id'])) return null;

        $list = new ArrayCollection();
        foreach($images['profiles'] AS $image) {
            $list->add( new Image($image) );
        }
        return $list;
    }

}
