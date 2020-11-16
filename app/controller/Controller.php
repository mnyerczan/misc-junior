<?php

namespace App\Controller;
use App\Model\ViewParameters;
use App\Core\User;


class Controller
{
    protected array $model = [];

    protected function put(string $name, $value)
    {
        $this->model[$name] = $value;
    }

    public function Response( ViewParameters $viewParameters)
    {
        if(!isset($this->model["user"]))
            $this->put("user", User::class);

        extract($this->model);
        
        
        if (is_numeric(strpos($viewParameters->get("view"), "redirect")))
            return header("location: ".substr($viewParameters->get("view"), 9));


        ob_clean();
        ob_start();        

        require_once "app/template/_layout.php";
        ob_end_flush();
    }
}