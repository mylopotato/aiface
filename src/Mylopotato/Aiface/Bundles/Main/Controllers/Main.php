<?php

namespace Mylopotato\Aiface\Bundles\Main\Controllers;

use Symfony\Component\HttpFoundation\Response;
use Mylopotato\Aiface\Core\Controller;

/**
 * Main controller
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
class Main extends Controller
{
    /**
     * Index action
     */
    public function index()
    {
        echo "Hello world. YOLO!";
    }

    public function show404(string $path)
    {
        $this->response->setStatusCode(Response::HTTP_NOT_FOUND);
        echo "Not found: ", \htmlspecialchars($path);
    }

    public function showApplicationError(\Throwable $throwable)
    {
        $this->response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        echo $throwable->getMessage();
    }
}