<?php


namespace App\Model;

use InvalidArgumentException;

class Entity
{
    public function get($name)
    {
        if (array_key_exists($name, get_object_vars($this)))
            return $this->$name;
        throw new InvalidArgumentException("The needed member variable \"{$name}\" does not exists!");
    }
}