<?php
require_once ("config/base.php");
require_once ("core/boot.php");


if (_DEBUG == true) {
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}else {
    ini_set('display_errors',0);
    error_reporting(E_NOTICE);
}


#Router
use core\RouterXML;
if (_API) {
    $router = new RouterXML(_ROUTES_API_PATCH."routing.xml");
    $data = $router->get($router->getUri());
    $router->run($data, _CONTROLLER_PATCH_API);
}else {
    header("HTTP/1.0 404 Not Found");
}

