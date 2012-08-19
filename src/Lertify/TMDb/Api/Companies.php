<?php

namespace Lertify\TMDb\Api;

use Lertify\TMDb\Api\Data\Company\Company;
use Lertify\TMDb\Api\Data\Company\Movie;
use Lertify\TMDb\Api\Data\ArrayCollection;
use Lertify\TMDb\Api\Data\PagedCollection;

class Companies extends AbstractApi
{

    /**
     * Get company info by ID
     *
     * @link http://help.themoviedb.org/kb/api/company-info
     *
     * @return Company
     */
    public function info( $id ) {
        $company = $this->get('company/' . $id);
        return new Company($company);
    }

    /**
     * Get movies associated with a company
     *
     * @link http://help.themoviedb.org/kb/api/company-movies
     *
     * @param Company|integer $company ID of the company
     * @return PagedCollection
     */
    public function movies( $company ) {
        if($company instanceof Company) $id = $company->getId();
        else $id = $company;

        $self = $this;
        $page_callback = function($page) use($self, $id) {
            $results = $self->get('company/'.$id.'/movies', array('page' => $page));

            if(!isset($results['results'])) return null;

            $list = new ArrayCollection();
            foreach($results['results'] AS $movie) {
                $list->set( $movie['id'] , new Movie($movie) );
            }

            return array('results' => $list, 'total_pages' => $results['total_pages'], 'total_results' => $results['total_results']);
        };

        return new PagedCollection($page_callback);
    }

}
