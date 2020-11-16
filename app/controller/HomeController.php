<?php

namespace App\Controller;

use App\Model\ViewParameters;
use App\Core\User;


class HomeController extends Controller
{
    public function index()
    {

        $this->put("user", User::class);
        $this->Response(new ViewParameters("homePage", "Wellcome"));
    }
}