<?php
namespace Green\Validations;

use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Container\Container;

class ValidatorFactory
{
    protected $factory;
    
    public function __construct()
    {
        $loader = new FileLoader(new Filesystem, 'lang');
        $translator = new Translator($loader, 'en');
        $this->factory = new Factory($translator, new Container);
    }
    
    public function __call($method, $args)
    {
        return call_user_func_array([$this->factory, $method], $args);
    }
}