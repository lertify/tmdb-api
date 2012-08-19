<?php

namespace Lertify\TMDb\Api\Data\Company;

use Lertify\TMDb\Api\Data\AbstractData;

class Company extends AbstractData
{

    public $id;
    public $name;
    public $description;
    public $parent_company;
    public $headquarters;
    public $homepage;
    public $logo_path;

}
