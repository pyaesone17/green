<?php 
namespace Green\Log;

interface LoggerContract
{
    public function info($message,$extra);
    public function warning($message,$extra);
    public function error($message,$extra);
}
