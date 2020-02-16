<?php
namespace core;


class RouterXML
{
    private $route = array();

    /*
    *	@param string	$file - Назва XML-файлу з правилами
    *	@param bool		$debug - Якщо true оновлення routing.xml.dat
    */
    public function __construct ($file)
    {
        if (!_ROUTING_DEBUG && file_exists($file . '.dat') ) {
            $this->route = unserialize(file_get_contents($file . '.dat'));
        } elseif (file_exists($file)) {
            $result = $this->get_routing(simplexml_load_file($file));
            $this->route = $result;
            $serialized = serialize($result);
            file_put_contents($file . '.dat', $serialized);
        } else {
            echo "Exceptions: Route file not found!";
        }
    }

    /*
    *	@param string	$url
    *	@return array
    */
    public function get($url)
    {
        $url = array_filter(explode('/', $url), 'mb_strlen');
        if (empty($url)) {
            $result = $this->index();
        } else {
            $result = $this->get_params($url, $this->route['route']);
            if (empty($result)) {
                $result = $this->not_found();
            }
        }

        return $result;
    }
    /*
    *	@return array
    */
    public function not_found()
    {
        $route = $this->route['system']['error_404'];
        $query_values = array();
        if (isset($route['values'])) {
            $query_values = $route['values'];
        }
        return array (
            'controller'	=> $route['params']['controller'],
            'action'		=> $route['params']['action'],
            'values'		=> $query_values,
        );
    }
    /*
    *	@return array
    */
    public function forbidden()
    {
        $route = $this->route['system']['forbidden'];
        $query_values = array();
        if (isset($route['values'])) {
            $query_values = $route['values'];
        }
        return array (
            'controller'	=> $route['params']['controller'],
            'action'		=> $route['params']['action'],
            'values'		=> $query_values,
        );
    }
    /*
    *	@return array
    */
    public function index()
    {
        $route = $this->route['system']['index'];
        $query_values = array();
        if (isset($route['values'])) {
            $query_values = $route['values'];
        }
        return array (
            'controller'	=> $route['params']['controller'],
            'action'		=> $route['params']['action'],
            'values'		=> $query_values,
        );
    }

    /*
    *	@param array	$match	Array of url data
    *	@param array	$route	An array of routing data
    *	@return array|false
    */
    private function get_params(& $match, $route)
    {
        if (!empty($match)){
            $result = false;
            $string = array_shift($match);
            $array_link = false;
            $query_values = array();
            if (isset ($route[0][$string]) ) {
                $array_link = $route[0][$string];
            } elseif(isset($route[1])) {
                foreach ($route[1] as $key => &$value) {
                    if (isset($value['params']['regex'])) {
                        if (preg_match($value['params']['regex'], $string, $temp_values)) {
                            $array_link = &$value;
                            foreach ($temp_values as $k =>$finded) {
                                if (isset ($value['params']['values'][$k]) ) {
                                    $query_values[$value['params']['values'][$k]] = $finded;
                                }
                            }
                            break;
                        }
                    }
                }
            }
            if ($array_link) {
                if (empty($match)){
                    return array (
                        'controller'	=> $array_link['params']['controller'],
                        'action'		=> $array_link['params']['action'],
                        'values'		=> $query_values,
                    );
                } elseif (!empty ($array_link['items']) ) {
                    $sub_result = $this->get_params($match, $array_link['items']);
                    if ($sub_result && !empty($query_values)) {
                        $sub_result['values'] = array_merge($query_values, $sub_result['values']);
                    }
                    return $sub_result;
                }
            }
            return false;
        }
    }


    /*
    *	@param SimpleXMLElement	$xml	Contents of the xml file with routing rules
    *	@return array|false
    */
    private function get_routing($xml)
    {
        $routes = $xml->xpath('/root/routes');
        $route['route'] = $this->build_routing($routes[0]);
        $temp = $xml->xpath('/root/system');
        $temp = $this->build_routing($temp[0]);
        $route['system'] = $temp[0];
        return $route;
    }

    /*
    *	@param SimpleXMLElement	$xml	The xml node
    *	@return array|false
    */
    private function build_routing ($xml)
    {
        $routes = false;
        foreach ($xml->children() as $route) {
            $params = array();
            $result_route = array();
            $element_name = (string)$route['match'];
            $type = 0;
            foreach($route->attributes() as $key => $value) {
                $params[(string)$key] = (string)$value;
            }
            if ($route->count() > 0) {
                $sub_items = $this->build_routing($route);
                if ($sub_items) {
                    $result_route['items'] = $sub_items;
                }
            }

            if(strpos($params['match'], '{') !== false) {
                preg_match_all('/\{(.+)(\|num|\|str|)\}/siuU', $params['match'], $match_attrs, PREG_SET_ORDER);
                foreach($match_attrs as $key => $varible) {
                    $params['match'] = str_replace("{" . $varible[1] . "}", '(.+)', $params['match']);
                    $params['match'] = str_replace("{" . $varible[1] . "|num}", '(\d*)', $params['match']);
                    $params['match'] = str_replace("{" . $varible[1] . "|str}", '([а-яёa-z1-9]*)', $params['match']);
                    $params['values'][($key+1)] = $varible[1];
                }
                $params['match'] = '/^' . $params['match'] .'$/iu';
                $params['regex'] = $params['match'];

                $element_name = crc32($params['match']);
                $type = 1;
            }
            $result_route['params'] = $params;
            $routes[$type][$element_name] = $result_route;

        }
        return $routes;
    }


    /**
     * @return bool|string
     */
    public function getUri()
    {
        $uri = !empty($_SERVER['REQUEST_URI']) ? '/'.trim($_SERVER['REQUEST_URI'],'/') : false;
        #return ($uri === _URL_REQUEST_INDEX) ? "/" : str_replace(_URL_REQUEST_INDEX, "", $uri);
        return $uri;
    }


    private function validate ($date = array()) {

    }

    public function run($data = array(), $controller_patch = _CONTROLLER_PATCH_HTTP)
    {
        $error = true;
        if (!empty($data))
        {
            $error = false;


            $controller_name  = ucfirst($data['controller'])."Controller";

            $controller_patch = $controller_patch.$controller_name.'.php';
            $action_name = 'action_'.$data['action'];
            $parametrs_action = $data['values'];

            if (file_exists($controller_patch)){
                include_once ($controller_patch);

                if (class_exists($controller_name))
                {
                    $controller_obj = new $controller_name;
                    $result = call_user_func_array(array($controller_obj,$action_name),$parametrs_action);

                }else
                {
                    Error::ShowError("Router Error: 'core/Router_XML.php' 245, class_exists", "Router", "error");
                    $error = true;
                }
            }
            else
            {
                Error::ShowError("Router Error: 'core/Router_XML.php' 242, file_exists", "Router", "error");
                $error = true;
            }
        }
    }
}