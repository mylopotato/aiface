<?php

namespace PHPPM\Bridges;

use DI\Container;
use DI\ContainerBuilder;
use PHPPM\Bootstraps\ApplicationEnvironmentAwareInterface;
use Mylopotato\Aiface\Application;

/**
 * Class Bootstrap
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
class Bootstrapper implements ApplicationEnvironmentAwareInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    private $appenv;

    /**
     * @var bool
     */
    private $isDebug;

    /**
     * @param string $appenv
     * @param bool $debug
     * @throws \Exception
     */
    public function initialize($appenv, $debug)
    {
        $this->appenv = $appenv;
        $this->isDebug = $debug;
        $this->initApp();
    }

    /**
     * @return Application
     */
    public function getApplication(): Application
    {
        return $this->app;
    }

    /**
     * @throws \Exception
     */
    protected function initApp(): void
    {
        if (!$this->app) {
            $rootPath = \dirname(__DIR__);
            $autoloadPath = \implode(
                DIRECTORY_SEPARATOR,
                [
                    $rootPath,
                    "vendor",
                    "autoload.php",
                ]
            );
            /** @noinspection PhpIncludeInspection */
            require $autoloadPath;

            $bundles = require $rootPath . "/config/bundles.php";

            $containerBuilder = new ContainerBuilder();
            $container = $containerBuilder->build();
            $container->set("bundles", $bundles);

            //

            $this->app = new Application($container);
        }
    }
}