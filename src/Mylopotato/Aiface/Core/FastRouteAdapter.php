<?php

namespace Mylopotato\Aiface\Core;

use FastRoute\BadRouteException;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Mylopotato\Aiface\Core\Exceptions\MethodNotAllowedException;
use Mylopotato\Aiface\Core\Exceptions\NotFoundException;
use Mylopotato\Aiface\Core\Exceptions\RouterException;
use Mylopotato\Aiface\Core\Interfaces\Router;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Router
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package Mylopotato\Aiface\Core
 */
class FastRouteAdapter implements Router
{
    /**
     * @var array[]
     */
    private $routes = [];

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * FastRouteAdapter constructor.
     *
     * @param $routes
     * @throws RouterException
     */
    public function __construct($routes)
    {
        $this->routes = $routes;

        try {
            $this->dispatcher = \FastRoute\simpleDispatcher(function (RouteCollector $r) {
                foreach ($this->routes as $path => $route) {
                    foreach ($route as $_method => $handler) {
                        if (!\strpos($handler, "@")) {
                            throw new RouterException("Bad handler name");
                        }

                        $methods = \explode(
                            " ",
                            \strtoupper($_method)
                        );
                        $r->addRoute($methods, $path, $handler);
                    }
                }
            });
        } catch (BadRouteException $e) {
            throw new RouterException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @inheritdoc
     */
    public function getHandler(Request $request): HandlerInfo
    {
        $httpMethod = $request->getMethod();
        $uri = $request->getRequestUri();

        if ($pos = \strpos($uri, '?') !== false) {
            $uri = \substr($uri, 0, $pos);
        }

        $uri = \rawurldecode($uri);
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                throw new NotFoundException($uri);

            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedException(
                    $routeInfo[0],
                    $httpMethod,
                    $uri
                );

            case Dispatcher::FOUND:
                /** @var string $handler */
                /** @var array $handler */
                $handler = $routeInfo[1];
                $args = $routeInfo[2];
                $aHandler = \explode("@", $handler);

                return new HandlerInfo(
                    $aHandler[0],
                    $aHandler[1],
                    $args
                );
        }
    }
}