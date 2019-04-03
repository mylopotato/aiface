<?php

namespace PHPPM\Bridges;

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

    protected function initApp(): void
    {
        if (!$this->app) {
            $autoloadPath = \implode(
                DIRECTORY_SEPARATOR,
                [
                    \dirname(__DIR__),
                    "vendor",
                    "autoload.php",
                ]
            );
            /** @noinspection PhpIncludeInspection */
            require $autoloadPath;

            $this->app = new Application();
        }
    }
}