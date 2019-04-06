<?php

namespace AifaceTests;

use DI\Container;
use Mockery\MockInterface;
use Mylopotato\Aiface\Application;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ApplicationTest
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package AifaceTests
 */
class ApplicationTest extends TestCase
{
    /**
     * @var Container|MockInterface
     */
    private $containerMock;

    /**
     * @var Request|MockInterface
     */
    private $requestMock;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        $this->containerMock = \Mockery::mock(Container::class);
        $this->requestMock = \Mockery::mock(Request::class);

        // Prepare mocks
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
            $this->containerMock
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
        $instance = $this->getInstance();
        $this->assertInstanceOf(
            ResponseInterface::class,
            $instance->handle($this->requestMock)
        );
    }
}
