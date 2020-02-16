<?php


namespace core\helpers\interfaces;

/**
 * Interface ArrayToObject
 * @package core\helpers\interfaces
 *
 * Інтерфейс для забезпечення доступу до елементів масиву як властивості класу
 *
 * Interface for secure access to the elements of the mass media as a power class
 *
 */
interface ArrayToObject
{
    public function __get($name);
    public function set();
}