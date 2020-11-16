<?php

namespace App\Model;


/**
 * Table -> Items
 */
class ItemEntity extends Entity
{
    public string $name;
    public int $column;
    public int $positionY;
}