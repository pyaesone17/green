<?php 
namespace Green\Log;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class MonoLogger implements LoggerContract
{
    protected $log;

    public function __construct() 
    {
        $this->log = new Logger('name'); 
        $this->log->pushHandler(new StreamHandler(\Green\App::$basePath.'/logs/audit.log', Logger::DEBUG));
    } 

    public function info($message,$extra)
    {
        $this->log->info($message, $extra);
    }

    public function warning($message,$extra)
    {
        $this->log->warning($message,$extra);
    }

    public function error($message,$extra)
    {
        $this->log->error($message,$extra);
    }
}
