<?php

namespace AifaceTests\Core;

use AifaceTests\Cases\AifaceTestCase;
use AifaceTests\Stubs\StubController;
use Mylopotato\Aiface\Core\Exceptions\RouterException;
use Mylopotato\Aiface\Core\FastRouteAdapter;
use Mylopotato\Aiface\Core\HandlerInfo;
use Mylopotato\Aiface\Core\Interfaces\Router;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class FastRouteAdapterTest
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package PHPPM\tests\AifaceTests\Core
 */
class FastRouteAdapterTest extends AifaceTestCase
{
    private $routes = [];

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {

    }

    /**
     * @inheritdoc
     */
    protected function tearDown(): void
    {
        \Mockery::close();
        $this->routes = [];
    }

    /**
     * @return FastRouteAdapter
     * @throws \Mylopotato\Aiface\Core\Exceptions\RouterException
     */
    private function getInstance(): FastRouteAdapter
    {
        return new FastRouteAdapter($this->routes);
    }

    /**
     * @throws \Exception
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(Router::class, $this->getInstance());
    }

    /**
     * @throws \Exception
     */
    public function testRouteException()
    {
        $this->routes = [
            "/" => [
                "GET POST" => StubController::class . "index",
            ],
        ];

        $this->expectException(RouterException::class);
        $this->expectExceptionMessage("Bad handler name");
        $this->getInstance();
    }

    /**
     * @throws \Exception
     */
    public function testGetHandler()
    {
        $this->routes = [
            "/" => [
                "GET POST" => StubController::class . "@index",
            ],
        ];

        // Stubs
        $stubRequest = Request::create(
            "https://example.com",
            "GET"
        );

        // Test
        $instance = $this->getInstance();
        $handlerInfo = $instance->getHandler($stubRequest);
        $this->assertInstanceOf(HandlerInfo::class, $handlerInfo);
        $this->assertEquals(StubController::class, $handlerInfo->getClassName());
        $this->assertEquals("index", $handlerInfo->getMethodName());
        $this->assertTrue(empty($handlerInfo->getArguments()));
    }
}
