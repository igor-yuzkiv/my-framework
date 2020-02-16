<?php
require_once ("config/base.php");
require_once ("core/boot.php");

use core\RouterXML;

if (_DEBUG == true) {

    require_once (_ROOT."core/helpers/dump.php");

    ini_set('display_errors',1);
    error_reporting(E_ALL);
}else {
    ini_set('display_errors',0);
    error_reporting(E_NOTICE);
}





#Router
$router = new RouterXML(_ROUTES_HTTP_PATCH."routing.xml");
$data = $router->get($router->getUri());
$router->run($data, _CONTROLLER_PATCH_HTTP);
?>
