<?php

use core\BaseController;

/**
 *
 */
class ErrorsController extends BaseController
{

  public function action_error_404 () {
    echo "<h1> ERROR 404 </h1>";
  }

  public function action_error_403 () {
    echo "<h1> ERROR 403 </h1>";
  }

}
