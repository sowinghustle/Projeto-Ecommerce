<?php

class Bookerr extends Exception
{
    private $type = "";

    public static $VALIDATION_ERROR_TYPE = "validation_error";
    public static $BAD_REQUEST = "bad_request";
    public static $EXCEPTION_TYPE = "exception";

    private function __construct($type, $message, $code = 0, $previous = null)
    {
        $this->type = $type;
        parent::__construct($message, $code, $previous);
    }

    public function __toString(): string
    {
        return "";
    }

    public function getType(): string
    {
        return $this->type;
    }

    public static function ValidationError($message): Bookerr
    {
        return new Bookerr(self::$VALIDATION_ERROR_TYPE, $message, 403);
    }

    public static function BadRequest($message): Bookerr
    {
        return new Bookerr(self::$BAD_REQUEST, $message, 400);
    }

    public static function Exception($message): Bookerr
    {
        return new Bookerr(self::$EXCEPTION_TYPE, "Desculpe, algo deu errado. Tente novamente mais tarde.", 500);
    }
}
