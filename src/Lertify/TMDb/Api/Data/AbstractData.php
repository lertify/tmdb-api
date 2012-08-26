<?php

namespace Lertify\TMDb\Api\Data;

use Serializable, Exception;

abstract class AbstractData
{

    public function __construct($data) {
        foreach($data as $key => $value){
            $this->{$key} = $value;
        }
    }

    public function __call($key, $arguments) {
        if(method_exists($this, $key))
        {
            return call_user_func_array(array($this, $key), $arguments);
        }

        if (property_exists($this, $key)) {
            if(count($arguments) == 0)
                return $this->__get($key);
            elseif(count($arguments) == 1)
                return $this->__set($key, $arguments[0]);
        }

        if($key == 'set' && count($arguments) == 2) {
            return $this->__set($arguments[0], $arguments[1]);
        }

        if($key == 'get' && count($arguments) == 1) {
            return $this->__get($arguments[0]);
        }

        if(substr($key, 0, 3) == 'set' && count($arguments) == 1) {
            return $this->__set( lcfirst( substr($key, 3) ) , $arguments[1]);
        }

        if(substr($key, 0, 3) == 'get' && count($arguments) == 0) {
            return $this->__get( lcfirst( substr($key, 3) ) );
        }

        throw new Exception("Undefined method ".$key.".");
    }

    public function __set($key, $value)
    {
        $unc_key = $this->uncamelize($key);
        if (property_exists($this, $unc_key)) {
            $name = 'set' . preg_replace('/_([A-Za-z0-9])/e', strtoupper('\\1'), ucfirst($key));
            if (method_exists($this, $name))
                $this->{ $name }($value);
            else
                $this->{ $unc_key } = $value;
                //throw new Exception("Property '$key' is read-only.");
        } else {
            throw new Exception("Undefined property ".$key." (".$unc_key.").");
        }
        return $this;
    }

    public function __get($key)
    {
        $unc_key = $this->uncamelize($key);
        if (property_exists($this, $unc_key)) {
            $name = 'get' . preg_replace('/_([A-Za-z0-9])/e', strtoupper('\\1'), ucfirst($key));
            if (method_exists($this, $name))
                return $this->{ $name }();
            else
                return $this->{ $unc_key };
        } else {
            throw new Exception("Undefined property ".$key." (".$unc_key.").");
        }
    }

    private function uncamelize($camel)
    {
        return strtolower( preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1_', $camel) );
    }

}
