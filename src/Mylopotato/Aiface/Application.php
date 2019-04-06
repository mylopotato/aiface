<?php

namespace Mylopotato\Aiface;

use DI\Container;
use Mylopotato\Aiface\Core\Exceptions\MethodNotAllowedException;
use Mylopotato\Aiface\Core\Exceptions\NotFoundException;
use Mylopotato\Aiface\Core\Interfaces\Router;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Application
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package Mylopotato\Aiface
 */
class Application implements HttpKernelInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Router
     */
    private $router;

    /**
     * Application constructor.
     *
     * @param Router $router
     * @param Container $container
     */
    public function __construct(Router $router, Container $container)
    {
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * @inheritdoc
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        try {
            $handlerInfo = $this->router->getHandler($request);
        } catch (NotFoundException $e) {
            throw $e; // @FIXME Make graceful error
        } catch (MethodNotAllowedException $e) {
            throw $e; // @FIXME Make graceful error
        }

        $response = new Response();
        $this->container->set("response", $response);
        $controllerInstance = $this
            ->container
            ->make($handlerInfo->getClassName(), []);
        \ob_start();
        \call_user_func_array(
            [
                $controllerInstance,
                $handlerInfo->getMethodName()
            ],
            $handlerInfo->getArguments()
        );
        $output = \ob_get_contents();
        \ob_end_clean();

        if ($output) {
            $response->setContent($output);
        }

        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );

        return $psrHttpFactory->createResponse($response);
    }
}