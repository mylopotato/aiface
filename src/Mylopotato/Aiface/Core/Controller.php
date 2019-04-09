<?php

namespace Mylopotato\Aiface\Core;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class Controller
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
abstract class Controller
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * Controller constructor.
     *
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        $this->response = $response;
    }
}