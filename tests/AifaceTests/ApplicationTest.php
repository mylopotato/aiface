<?php

namespace AifaceTests;

use AifaceTests\Cases\AifaceTestCase;
use AifaceTests\Stubs\StubController;
use Mockery\MockInterface;
use Mylopotato\Aiface\Application;
use Mylopotato\Aiface\Core\HandlerInfo;
use Mylopotato\Aiface\Core\Interfaces\Router;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApplicationTest
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package AifaceTests
 */
class ApplicationTest extends AifaceTestCase
{
    /**
     * @var Request|MockInterface
     */
    private $requestMock;

    /**
     * @var Router|MockInterface
     */
    private $routerMock;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->requestMock = \Mockery::mock(Request::class);
        $this->routerMock = \Mockery::mock(Router::class);
        $this->container->set("request", $this->requestMock);
        $this->container->set("router", $this->routerMock);
    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        \Mockery::close();
    }

    /**
     * @return Application
     */
    private function getInstance(): Application
    {
        return new Application(
            $this->routerMock,
            $this->container
        );
    }

    public function testConstruct()
    {
        $this->assertInstanceOf(Application::class, $this->getInstance());
    }

    /**
     * @throws \Exception
     */
    public function testHandle()
    {
        $this
            ->routerMock
            ->shouldReceive("getHandler")
            ->withAnyArgs()
            ->andReturn(new HandlerInfo(StubController::class, "index", []));

        $instance = $this->getInstance();
        $this->assertInstanceOf(
            ResponseInterface::class,
            $instance->handle($this->requestMock)
        );
    }
}
