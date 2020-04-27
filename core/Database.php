<?php


namespace Intass;


abstract class Database
{
    private static $instance;
    protected $host;
    protected $username;
    protected $password;
    protected $database;

    /**
     * Database constructor.
     * @param $host
     * @param $username
     * @param $password
     * @param $database
     */
    public function __construct($host, $username, $password, $database)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;

        $this->setup();
        static::$instance = $this;
    }

    public abstract function setup();

    public abstract function query($query);

    public abstract function update($statement, $args);

    /**
     * @return Database
     */
    public static function getInstance()
    {
        return static::$instance;
    }
}
