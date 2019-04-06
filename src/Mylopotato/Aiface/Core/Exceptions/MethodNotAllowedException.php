<?php

namespace Mylopotato\Aiface\Core\Exceptions;

use Throwable;

/**
 * Class MethodNotAllowedException
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package Mylopotato\Aiface\Core\Exceptions
 */
class MethodNotAllowedException extends RouterException
{
    /**
     * @var array
     */
    private $expectedMethods;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $path;

    /**
     * MethodNotAllowedException constructor.
     *
     * @param array $expectedMethods
     * @param string $method
     * @param string $path
     */
    public function __construct(array $expectedMethods, string $method, string $path)
    {
        parent::__construct("Method not allowed", 405);
        $this->expectedMethods = $expectedMethods;
        $this->method = $method;
        $this->path = $path;
    }

    /**
     * @return array
     */
    public function getExpectedMethods(): array
    {
        return $this->expectedMethods;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}