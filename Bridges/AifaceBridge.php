<?php

namespace PHPPM\Bridges;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Mylopotato\Aiface\ApplicationFactory;
use Mylopotato\Aiface\Application;

/**
 * Class AifaceBridge
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
class AifaceBridge implements BridgeInterface
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var ApplicationFactory
     */
    private $bootstrapper;

    /**
     * @param string|null $appBootstrap
     * @param string $appenv
     * @param bool $debug
     * @throws \Exception
     */
    public function bootstrap($appBootstrap, $appenv, $debug)
    {
        $this->bootstrapper = new ApplicationFactory();
        $this->bootstrapper->initialize($appenv, $debug);
        $this->app = $this->bootstrapper->getApplication();
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws \Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $httpFoundationFactory = new HttpFoundationFactory();

        return $this->app->handle($httpFoundationFactory->createRequest($request));
    }
}