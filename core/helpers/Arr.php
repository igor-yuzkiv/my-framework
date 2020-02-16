<?php

namespace core\helpers;

trait Arr
{

    /**
     * @param array $array
     * @param $key
     * @param null $value
     * Set array item
     */
    public static function set (Array &$array, $key, $value = null )
    {
        if (!is_null($key)) {
            $array[$key] =  $value;
        }
    }

    /**
     * @param array $array
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function get (Array $array, $key, $default = null) {
        if (is_null($key)) {
            return $default;
        }

        if(array_key_exists($key, $array)) {
            return $array[$key];
        }
    }

}