<?php


namespace core\service\Http;

use core\helpers\Arr;
use core\helpers\interfaces\ArrayToObject;

class Request implements ArrayToObject
{

    /**
     * @var array
     *
     * _POST
     */
    private $field = [];

    /**
     * @param null $name
     * @return mixed|null
     */
    public function __get($name = null)
    {
        return Arr::get($this->field, $name, $this->field);
    }

    /**
     * Set $field
     */
    public function set()
    {
        $this->field = $_POST;
    }

    /**
     * PostRequest constructor.
     */
    public function __construct()
    {
        $this->set();
    }

    /**
     * @return bool
     */
    public function is_ajax() {
        if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }else return false;
    }
}