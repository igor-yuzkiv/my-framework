<?php


namespace Model;


use core\db\ActiveRecord;

class User extends ActiveRecord
{

    protected $table = 'user';


    public function test ()
    {
        return $this->find()->all();
    }

}