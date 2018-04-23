<?php 

namespace Green\Database;
use Illuminate\Database\Capsule\Manager as Capsule;

class Connection
{
    public static function boot()
    {
        $capsule = new Capsule;

        $capsule->addConnection(config('database'));
    
        //Make this Capsule instance available globally.
        $capsule->setAsGlobal();
    
        // Setup the Eloquent ORM.
        $capsule->bootEloquent();
    }
}
