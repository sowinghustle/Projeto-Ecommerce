<?php

class Session
{
    public function __construct()
    {
        Session::start();
    }

    public function set($key, $value)
    {
        if (is_null($value))
            Session::privUnset("$key");
        else
            Session::privSet("$key", $value);
    }

    public function get($key, $default = null)
    {
        return Session::privGet("$key", $default);
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function start()
    {
        session_start();
    }

    private static function privSet($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    private static function privGet($key, $default = null)
    {
        return isset ($_SESSION[$key]) ?
            $_SESSION[$key] :
            $default;
    }

    private static function privUnset($key)
    {
        unset($_SESSION[$key]);
    }
}
