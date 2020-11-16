<?php

namespace App\Controller;

use App\Model\ViewParameters;
use App\Core\User;

class NotFoundController extends Controller
{    
    public function index()
    {
        $this->put("user", User::class);
        $this->Response(new ViewParameters("_404", "Page Not Found"));
    }
}