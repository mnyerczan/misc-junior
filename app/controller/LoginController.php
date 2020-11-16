<?php

namespace App\Controller;

use App\Core\User;
use App\Model\UserEntity;
use App\Model\ViewParameters;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->put("user", User::class);        
    }

    public function index()
    {
        // Abstraháljuk az index metódust.
        if (isset($_POST["login-submit"])) {
            $this->put("loginName", $_POST["loginName"]);
            $this->put("password", $_POST["password"]);
            $this->put("errorMsg", "Your user name or password are incorrect.<br>
            Please try it again.");
        } 
        $this->Response(new ViewParameters("login", "Login"));
    }

    public function login()
    {
        if (!(isset($_POST["password"]) && isset($_POST["loginName"])))
            //  Ha hiányoznak a keresett változók, vissza.
            return $this->index();
        else {
            extract($_POST);
        }
        
        // Ha nem sikerült, vissza a login formra.        
        if (!User::login($loginName, $password))
            return $this->index();
  
        $this->Response(new ViewParameters("redirect: ".APPROOT, ""));
    }

    public function logout()
    {
        session_destroy();
        $this->Response(new ViewParameters("redirect: ".APPROOT, ""));
    }
}