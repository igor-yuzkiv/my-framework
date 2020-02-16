<?php
require_once ("vendor/autoload.php");

#path
define  ("_ROOT",                       $_SERVER['DOCUMENT_ROOT'].'/');
define  ("_CONTROLLER_PATCH_HTTP" ,     _ROOT.'app/Controller/Http/');
define  ("_CONTROLLER_PATCH_API" ,      _ROOT.'app/Controller/Api/');
define  ("_VIEW_DIR",                   _ROOT."view");
define  ("_VIEW_CASH_DIR",              _ROOT."storage/twig_cache/");
define  ("_STORAGE",                    _ROOT."storage/");
define  ("_ROUTES_HTTP_PATCH",          _ROOT."config/routing/http/");
define  ("_ROUTES_API_PATCH",           _ROOT."config/routing/api/");



#debug
define  ("_DEBUG",                true);
define  ("_ROUTING_DEBUG",        true);
define  ("_DEBUG_VIEW",           true);

define("_URL_REQUEST_INDEX", "/framework");

#API
define ("_API", false);

#base_config
define("_BASE_CONFIG", [
    'database' => [
        'db_host'       => 'mysql',
        'db_name'       => 'framework',
        'db_user'       => 'framework',
        'db_password'   => '4Vuv0Xk7%',
    ]
]);