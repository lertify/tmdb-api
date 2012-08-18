<?php

namespace Lertify\TMDb\Api\Data;

use Closure;
use Countable;
use IteratorAggregate;
use ArrayAccess;

interface Collection extends Countable, IteratorAggregate, ArrayAccess
{
    /**
     * An array containing the entries of this collection.
     *
     * @var array
     */
    private $_elements;


    public function add();

}
