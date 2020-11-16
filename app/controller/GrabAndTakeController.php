<?php

namespace App\Controller;

use App\Model\ViewParameters;
use App\Model\ItemEntity;
use App\Core\DB;
use Exception;

class GrabAndTakeController extends Controller
{
    public function index()
    {
        $items = DB::selectAll("SELECT * FROM `Items` ORDER BY `column`, `positionY`", [], ItemEntity::class);

        $this->put("items", json_encode($items));

        return $this->Response(
            new ViewParameters("grabAndTake", "Grab and take")
        );
    }

    public function update()
    {
        $items = json_decode($_POST["params"]);

        $params = [];
        $sql = "";

        for($i = 0; $i < count($items); $i++) {
            $params[":name".$i] = $items[$i]->name;
            $params[":positionY".$i] = $items[$i]->positionY;
            $sql.= "UPDATE `Items` SET `positionY` = :positionY{$i} WHERE `name` LIKE :name{$i}; ";
        }
        try {
            DB::execute($sql, $params);
            echo "Your list has been successful saved.";
        } catch (Exception $e) {
            echo "Sorry, something went wrong. We can not update your list.";
        }
        
    }
}