<?php

class Hash
{
    public static function make($input, $algorithm = PASSWORD_DEFAULT)
    {
        return password_hash($input, $algorithm);
    }

    public static function check($input, $hash)
    {
        return password_verify($input, $hash);
    }
}
