<?php

class Session
{
    public function __construct()
    {
        self::start();
    }

    public function has($key): bool
    {
        return self::_sessionHas($key);
    }

    public function set($key, $value)
    {
        self::_sessionSet("$key", $value);
    }

    public function unset($key)
    {
        self::_sessionUnset("$key");
    }

    public function get($key, $default = null)
    {
        return self::_sessionGet("$key", $default);
    }

    public function destroy()
    {
        session_destroy();
    }

    private static function start()
    {
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
    }

    private static function _sessionHas($key)
    {
        return isset($_SESSION[$key]);
    }

    private static function _sessionSet($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    private static function _sessionGet($key, $default = null)
    {
        return self::_sessionHas($key) ?
            $_SESSION[$key] :
            $default;
    }

    private static function _sessionUnset($key)
    {
        unset($_SESSION[$key]);
    }
}
