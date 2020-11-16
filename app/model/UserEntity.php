<?php

namespace App\Model;


use InvalidArgumentException;

/**
 * Table -> Users 
 */
class UserEntity extends Entity
{
    protected int $id;
    protected string $name;
    protected string $password;   
}