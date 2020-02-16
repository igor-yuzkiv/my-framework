<?php


namespace core;


/**
 * Class ServiceManager
 * @package core
 */
class ServiceManager
{

    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @var array
     * Storage services
     */
    private $services = array();

    /**
     * ServiceManager constructor.
     */
    private function __construct()
    {

    }

    /**
     * @return ServiceManager
     */
    public static function init () :self{
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Load defined services
     */
    public function boot() {
        $this->services = require_once ("config/services.php");
    }

    /**
     * @param $alias
     * @return object|null
     */
    public function __get($alias)
    {
        if (key_exists($alias, $this->services)) {
            return new $this->services[$alias];
        }else return null;
    }

    /**
     * @param $alias
     * @param $class
     */
    public function __set($alias, $class)
    {
        if (!key_exists($alias, $this->services)) {
            $this->services[$alias] = $class;
        }
    }

    /**
     * @return array|mixed
     */
    public function list_services () {
        return $this->services;
    }

    private function __clone() {}
    private function __wakeup() {}
}