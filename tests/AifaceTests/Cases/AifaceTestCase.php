<?php

namespace AifaceTests\Cases;

use DI\Container;
use DI\ContainerBuilder;
use PHPUnit\Framework\TestCase;

/**
 * Class AifaceTestCase
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package AifaceTests\Cases
 */
class AifaceTestCase extends TestCase
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * AifaceTestCase constructor.
     *
     * @param string|null $name
     * @param array $data
     * @param string $dataName
     * @throws \Exception
     */
    public function __construct(?string $name = null, array $data = [], string $dataName = '')
    {
        global $definitions;

        parent::__construct($name, $data, $dataName);

        $containerBuilder = new ContainerBuilder();
        $containerBuilder->addDefinitions($definitions);
        $this->container = $containerBuilder->build();
    }

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
    }
}