<?php

namespace App\Model;



use InvalidArgumentException;


class ViewParameters 
{
    private string $view;
    private string $title;


    public function __construct(string $view, string $title)
    {
        $this->view = $view;
        $this->title = $title;
    }

    public function get($name)
    {
        if (array_key_exists($name, get_object_vars($this)))
            return $this->$name;
        throw new InvalidArgumentException("The needed member variable does not exists: ".$name);
    }
}