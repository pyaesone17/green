<?php 
namespace Green\Log;

class LogManager
{
    public function __construct(LoggerContract $logger)
    {
        $this->logger = $logger;
    }

    public function writeLog($level, $message, $extra)
    {
        if(method_exists($this->logger,$level)){
            $this->logger->{$level}($message,$extra);
        } else {
            throw new LogLevelNotFoundException();
        }
    }
} 
