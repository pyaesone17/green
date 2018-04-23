<?php 
namespace Green\Log;

class NullLogger implements LoggerContract
{
    public function info($message)
    {
        // do nothing it is null object pattern
    }

    public function warning($message)
    {
        // do nothing it is null object pattern
        // when u don't want to log anything 
        // and u dont want to delete log line
        // in case u want to log again,
        // just switch driver
    }

    public function error($message)
    {
        // do nothing it is null object pattern
    }
}
