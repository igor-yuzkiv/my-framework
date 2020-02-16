<?php

use core\BaseController;

class IndexController extends BaseController
{

    public function action_index () {
        $request = new \core\service\Http\Request();
        dump($request->test);


        $this->view()->name("index") -> render();
    }

    public function action_test () {

    }


}