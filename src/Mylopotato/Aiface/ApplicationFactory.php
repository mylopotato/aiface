<?php

namespace Mylopotato\Aiface;

use DI\ContainerBuilder;
use Mylopotato\Aiface\Core\BundleManifestInterface;
use PHPPM\Bootstraps\ApplicationEnvironmentAwareInterface;

/**
 * Class ApplicationFactory
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
class ApplicationFactory implements ApplicationEnvironmentAwareInterface
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
            $rootPath = \dirname(\dirname(\dirname(__DIR__))); // @FIXME Зарефачить
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

            $containerBuilder = new ContainerBuilder();
            $bundles = require $rootPath . "/config/bundles.php";
            $rootDefinitions = require $rootPath . "/config/core-definitions.php";
            $containerBuilder->addDefinitions($rootDefinitions);

            $routes = [];

            foreach ($bundles as $bundleNS) {
                /** @var BundleManifestInterface $manifestInstance */
                $fqnBundleClassName = $bundleNS . "\\BundleManifest";
                $manifestInstance = new $fqnBundleClassName();
                $containerBuilder->addDefinitions($manifestInstance->getDefinitions());
                $routes = \array_merge($routes, $manifestInstance->getRoutes());
            }

            $container = $containerBuilder->build();

            $container->set("env", $this->appenv);
            $container->set("debug", $this->isDebug);
            $container->set("bundles", $bundles);
            $container->set("routes", $routes);

            $this->app = $container->make(
                Application::class,
                [
                    "container" => $container,
                ]
            );
        }
    }
}