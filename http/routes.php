<?php


return [
    /**
     * "url_regex_pattern" => [
     *      "controller" => "controller_class_full_path",                
     *      "action" => "methond_of_controller_class",
     *      "logged" => "is_logged_the_user"
     * ],
     */
    "GET" => [        
        "" => [
            "controller" => "App\Controller\HomeController",                
            "action" => "",
            "logged" => false
        ],
        "/login" => [
            "controller" => "App\Controller\LoginController",
            "action" => "",
            "logged" => false
        ],   
        "/logout" => [
            "controller" => "App\Controller\LoginController",
            "action" => "logout",
            "logged" => true
        ],
        "/gat" => [
            "controller" => "App\Controller\GrabAndTakeController",
            "action" => "",
            "logged" => true
        ],   
    ],
    "POST" => [
        "/login" => [
            "controller" => "App\Controller\LoginController",
            "action" => "login",
            "logged" => false
        ], 
        "/gat/update" => [
            "controller" => "App\Controller\GrabAndTakeController",
            "action" => "update",
            "logged" => true
        ]
    ]         
];