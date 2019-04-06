<?php

namespace Mylopotato\Aiface\Core;

/**
 * Class HandlerInfo
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package Mylopotato\Aiface\Core
 */
class HandlerInfo
{
    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var array
     */
    private $arguments = [];

    /**
     * HandlerInfo constructor.
     *
     * @author Mylopotato <mylopotato@yandex.ru>
     * @param string $className
     * @param string $methodName
     * @param string $arguments
     */
    public function __construct(string $className, string $methodName, array $arguments = [])
    {
        $this->className = $className;
        $this->methodName = $methodName;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @return string
     */
    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}