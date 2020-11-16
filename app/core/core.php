<?php


use Http\Router;


/**
 |--------------------------------
 | Ide jöhetne egy try-catch az alkalmazásból
 | a service-ok kivételének elkapására, amit egy error
 | View-al megjelenítnénk.
 |
 */

session_start();

\App\Core\DB::setup();
\App\Core\User::setup();

\Http\Router::route($cleanedUri);