<?php

namespace Mylopotato\Aiface\Core\Interfaces;

use FastRoute\BadRouteException;
use Mylopotato\Aiface\Core\Exceptions\MethodNotAllowedException;
use Mylopotato\Aiface\Core\Exceptions\NotFoundException;
use Mylopotato\Aiface\Core\Exceptions\RouterException;
use Mylopotato\Aiface\Core\HandlerInfo;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface Router
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package Mylopotato\Aiface\Core\Interfaces
 */
interface Router
{
    /**
     * Router constructor.
     *
     * @param array[] $routes
     * @throws RouterException
     */
    public function __construct(array $routes);

    /**
     * @param Request $request
     * @return HandlerInfo
     * @throws NotFoundException
     * @throws MethodNotAllowedException
     */
    public function getHandler(Request $request): HandlerInfo;
}