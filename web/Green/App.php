<?php 

namespace Green;

use League\Container\Container;
use League\Route\Strategy\JsonStrategy;
use Green\Router\Route;
use Green\Exceptions\GreenJsonStrategy;
use Green\Database\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\PsrHttpMessage\Factory\DiactorosFactory;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Green\Config\Repository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Green\Log\{LogManager, NullLogger, MonoLogger};

class App
{
    protected $container;
    public static $instance;
    public static $basePath;

    public function __construct($basePath) 
    {
        $container = new Container;
        $container->share('response', \Zend\Diactoros\Response::class);

        $container->share('request', function () {
            return \Zend\Diactoros\ServerRequestFactory::fromGlobals(
                $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES
            );
        });

        $container->share('emitter', \Zend\Diactoros\Response\SapiEmitter::class);

        $router = new \League\Route\RouteCollection($container);

        $container->add('router', function() use($router){
            return $router;
        });

        $this->container = $container;
        $this->setGlobal($basePath);
        $this->bootDatabase();
        $this->bootConfig();
        $this->bootLog();
        $this->setErrorHandler();
    }

    public function setGlobal($basePath)
    {
        self::$basePath = $basePath;
        self::$instance = $this;
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function run()
    {
        $response = $this->get('router')->dispatch($this->get('request'), $this->get('response'));
        return $this->container->get('emitter')->emit($response);
    }

    public static function basePath()
    {
        return static::$basePath;
    }

    public function bootDatabase()
    {
        Connection::boot();
    }

    public function bootConfig()
    {
        $this->container->share('config', $config = new Repository([]));
        $this->loadConfigurationFiles($config);
    }
    
    public function bootLog()
    {
        $driver = config('log.driver');
        $logger = null;

        if ($driver=='monolog') {
            $logger = new MonoLogger();
        } else {
            $logger = new NullLogger();
        }

        $this->container->share('log', function () use($logger)
        {
            return new LogManager($logger);
        });
    }

    protected function loadConfigurationFiles($repository)
    {
        $files = $this->getConfigurationFiles();

        if (! isset($files['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }

        foreach ($files as $key => $path) {
            $repository->set($key, require $path); 
        }
    }

    protected function getConfigurationFiles()
    {
        $files = [];
 
        $configPath = realpath(self::$basePath."/config");
        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);
            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }

        return $nested;
    }

    public function setErrorHandler()
    {   
        $this->container->share('error_handler', \Green\Exceptions\Handler::class);
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->container,$method),$args);
    }
}
