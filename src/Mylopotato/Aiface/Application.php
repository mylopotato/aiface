<?php

namespace Mylopotato\Aiface;

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use Mylopotato\Aiface\Core\BundleManifestInterface;
use Mylopotato\Aiface\Exceptions\ApplicationInitializationException;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Application
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 * @package Mylopotato\Aiface
 */
class Application implements HttpKernelInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * Application constructor.
     *
     * @param Container $container
     * @throws ApplicationInitializationException
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->initBundles();
    }

    /**
     * @inheritdoc
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        // @TODO: Handle request

        $response = new Response();
        $response->setContent("YOLO");

        $psr17Factory = new Psr17Factory();
        $psrHttpFactory = new PsrHttpFactory(
            $psr17Factory,
            $psr17Factory,
            $psr17Factory,
            $psr17Factory
        );

        return $psrHttpFactory->createResponse($response);
    }

    /**
     * @throws ApplicationInitializationException
     */
    private function initBundles()
    {
        try {
            if (!$this->container->has("bundles")) {
                throw new \RuntimeException("Bundles config not found");
            }

            /** @var string[] $bundles */
            $bundles = $this->container->get("bundles");

            foreach ($bundles as $bundleNS) {
                /** @var BundleManifestInterface $manifestInstance */

                if (false) { // @FIXME: To implement
                    $manifestInstance = $this
                        ->container
                        ->make($bundleNS . "\\BundleManifest");
                }
            }
        } catch (NotFoundException $e) {
            throw new ApplicationInitializationException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        } catch (DependencyException $e) {
            throw new ApplicationInitializationException(
                $e->getMessage(),
                $e->getCode(),
                $e
            );
        }
    }
}