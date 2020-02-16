<?php


namespace core;


class BaseController
{
    protected function view () {
        $base_view = new View();
        return $base_view;
    }
}