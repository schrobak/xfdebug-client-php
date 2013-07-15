<?php

error_reporting(0);

class XfDump
{
    public static function dump($data)
    {
        $backtrace = array_pop(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2));
        $info = "[TRACE] {$backtrace['file']}:{$backtrace['line']}:{$backtrace['function']}";

        $socket = self::connect();
        $msg = $info . "\n" . var_export($data, true);

        if (socket_send($socket, $msg, strlen($msg), 0) === false)
            die(self::error());

        socket_close($socket);
    }

    private static function connect()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, IPPROTO_IP);

        if ($socket === false)
            die(self::error());

        if (socket_connect($socket, '127.0.0.1', 2409) === false)
            die(self::error());

        return $socket;
    }

    private static function error()
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);

        return "[ERROR] $errormsg ($errorcode)";
    }
}