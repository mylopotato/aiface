<?php

namespace Mylopotato\Aiface\Core;

use DI\Definition\Source\DefinitionSource;

/**
 * Interface
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
interface BundleManifestInterface
{
    /**
     * @return array[]|DefinitionSource[]
     */
    public function getDefinitions(): array;

    /**
     * @return array[]
     */
    public function getRoutes(): array;
}