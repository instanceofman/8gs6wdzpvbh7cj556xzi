<?php

namespace Intass;

use Intass\Drivers\MysqlDatabase;

class Container
{
    /**
     * @return Container
     */
    private static $instance;

    protected $config;

    /**
     * @return Http
     */
    protected $http;

    /**
     * @return Database
     */
    protected $db;

    /**
     * @return Session
     */
    protected $session;

    /**
     * @return Container
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = new Container();
        }

        return static::$instance;
    }

    public function boot()
    {
        $this->config = require_once(APP_BASE_PATH . '/config.php');

        // Todo Temporary hard-code to select db driver
        if ($this->config['db']['driver'] === 'mysql') {
            $this->db = new MysqlDatabase(
                $this->config['db']['host'],
                $this->config['db']['username'],
                $this->config['db']['password'],
                $this->config['db']['database']
            );
        }

        // Init web session
        $this->session = new Session();

        $routes = require_once(APP_BASE_PATH . '/routes.php');

        // Step 2: Dispatch request
        $this->http = new Http($routes);

        $this->http
            ->dispatch()
            ->render();
    }

    /**
     * @return Database
     */
    public function getDatabase()
    {
        return $this->db;
    }

    /**
     * @return Database
     */
    public function getSession()
    {
        return $this->session;
    }
}
