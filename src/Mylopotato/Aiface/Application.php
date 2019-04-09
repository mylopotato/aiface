<?php

namespace Mylopotato\Aiface;

use DI\Container;
use Mylopotato\Aiface\Bundles\Main\Controllers\Main;
use Mylopotato\Aiface\Core\Controller;
use Mylopotato\Aiface\Core\Exceptions\NotFoundException;
use Mylopotato\Aiface\Core\Interfaces\Router;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
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

    private $defaultController = Main::class; // @FIXME config

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
        $response = new Response();
        $this->container->set("response", $response);

        try {
            try {
                $handlerInfo = $this->router->getHandler($request);
            } catch (NotFoundException $e) {
                $response->setContent(
                    $this->callAction(
                        $this->getController($this->defaultController),
                        "show404",
                        [$e->getPath()]
                    )
                );

                return $this->decorateResponse($response);
            }

            $controllerInstance = $this->getController($handlerInfo->getClassName());
            $response->setContent(
                $this
                    ->callAction(
                        $controllerInstance,
                        $handlerInfo->getMethodName(),
                        $handlerInfo->getArguments()
                    )
            );
        } catch (\Throwable $e) {
            $response->setContent(
                $this->callAction(
                    $this->getController($this->defaultController),
                    "showApplicationError",
                    [$e]
                )
            );
        }

        return $this->decorateResponse($response);
    }

    /**
     * @param string $className
     * @return Controller
     * @throws \Exception
     */
    private function getController(string $className): Controller
    {
        return $this
            ->container
            ->make($className);
    }

    /**
     * @param Controller $controllerInstance
     * @param string $action
     * @param array $args
     * @return string
     */
    private function callAction(Controller $controllerInstance, string $action, array $args): string
    {
        \ob_start();
        \call_user_func_array(
            [
                $controllerInstance,
                $action
            ],
            $args
        );
        $output = \ob_get_contents();
        \ob_end_clean();

        return $output;
    }

    /**
     * @param Response $response
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function decorateResponse(Response $response): ResponseInterface
    {
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