<?php


namespace Intass;


class Session
{
    private static $instance;

    public function __construct()
    {
        $this->initialize();

        static::$instance = $this;
    }

    public function initialize()
    {
        session_start();

        $default = [
            'logged_in' => false,
            'user' => null
        ];

        foreach ($default as $key => $value) {
            if (!isset($_SESSION[$key])) {
                $this->put($key, $value);
            }
        }
    }

    public function put($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key, $default = null)
    {
        if (!isset($_SESSION[$key])) {
            return $default;
        }

        return $_SESSION[$key];
    }

    /**
     * @return Session
     */
    public static function getInstance()
    {
        return static::$instance;
    }
}
