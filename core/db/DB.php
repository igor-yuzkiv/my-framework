<?php

namespace core\db;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use PDO;


class DB
{
    protected static $instance;
    protected static $query;

    /**
     * @var PDO
     */
    private     $link;

    /**
     * @var Logger
     */
    private     $log;

    /**
     * @var string|null
     */
    protected   $sql;


    /**
     * DB constructor.
     */
    public function __construct(){

        $this->log = new Logger("db");
        $this->log->pushHandler(new StreamHandler('storage/log/db.log'));

        if (!is_a($this->link, "PDO"))
        {
            $this->connection();
        }
    }

    /**
     * @return \Core\DB
     * Singleton
     */
    public static function inst () : DB
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * @return PDO|int
     *
     * connection
     */
    private function connection () {

        $config = _BASE_CONFIG['database'];

        try{
            $this->link = new PDO("mysql:host=". $config['db_host'] .";dbname=".
                $config['db_name'], $config['db_user'], $config['db_password']);

            if (_DEBUG) {
                $this->link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }

            return $this->link;
        }
        catch(PDOException $e)
        {
            $this->log->error("Підключення до бази `$this->DBNAME` не вдалось.");
            print("Error: ".$e->getMessage());
        }
    }

    /**
     * @param $sql
     * @return mixed
     */
    public function fetch_assoc ()
    {
        $sth =  $this->link->prepare($this->sql);
        $sth->execute();
        $result =  $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * @param bool $return_id
     * @return bool
     */
    public function execute ($return_id = false)
    {
        file_put_contents(_STORAGE."telegram_db.txt", $this->sql);
        $sth = $this->link->prepare($this->sql);
        $result = $sth->execute();
        return ($return_id) ? $this->link->lastInsertId() : $result ;
    }

    /**
     * @param $sql
     * @return $this
     */
    public function setSql ($sql) {
        $this->sql = $sql;
        return $this;
    }


    private function __clone(){}
    private function __wakeup(){}
}