<?php


namespace core\db;


class ActiveRecord
{
    /**
     * @var
     * Table name
     */
    protected $table;

    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
       $this->columns[$name] = $value;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->columns[$name];
    }

    /**
     * @return array
     * Clear and return columns
     */
    private function get_columns () {
        $col = $this->columns;
        $this->columns = [];
        return $col;
    }

    /**
     * @return mixed
     */
    protected function store () {
        return Query::table($this->table)->insert($this->get_columns());
    }

    /**
     * @param $where
     * @return bool|mixed
     */
    protected function update ($where) {
        return Query::table($this->table) -> where($where) ->update($this->get_columns());
    }

    /**
     * @param $where
     * @return bool|mixed
     */
    protected function remove ($where) {
        return Query::table($this->table) -> where($where) -> delete();
    }

    /**
     * @param string $column
     * @return Query
     */
    protected function find($column = "*") {
        return Query::table($this->table)->select($column);
    }

}