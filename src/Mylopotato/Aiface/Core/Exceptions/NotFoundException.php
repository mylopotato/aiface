<?php

namespace Mylopotato\Aiface\Core\Exceptions;

use Throwable;

/**
 * Class NotFoundException
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package Mylopotato\Aiface\Core\Exceptions
 */
class NotFoundException extends RouterException
{
    /**
     * @var string
     */
    private $path;

    /**
     * NotFoundException constructor.
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        parent::__construct("Not found", 404);

        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}