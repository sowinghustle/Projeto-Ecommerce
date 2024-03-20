<?php 

class Session
{
    public function __construct()
    {
        Session::start();
    }

    public static function destroy()
    {
        session_destroy();
    }

    public static function start() 
    {
        session_start();
    }

    public function set($key, $value)
    {
        if (is_null($value))
            Session::remove("LOCAL: $key");
        else 
            Session::set("LOCAL: $key", $value);
    }

    public function get($key, $default = null)
    {
        return Session::get("LOCAL: $key", $default);
    }

    private static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    private static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ?
            $_SESSION[$key] :
            $default;
    }

    private static function remove($key)
    {
        unset($_SESSION[$key]);
    }
}
