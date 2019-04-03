<?php

namespace PHPPM\Bridges;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Mylopotato\Aiface\Application;

/**
 * Class Bridge
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
class Bridge implements BridgeInterface // @FIXME Rename to AifaceBridge
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var Bootstrapper
     */
    private $bootstrapper;

    /**
     * @param string|null $appBootstrap
     * @param string $appenv
     * @param bool $debug
     */
    public function bootstrap($appBootstrap, $appenv, $debug)
    {
        $this->bootstrapper = new Bootstrapper();
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