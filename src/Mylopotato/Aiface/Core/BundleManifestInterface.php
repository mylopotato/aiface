<?php

namespace Mylopotato\Aiface\Core;

/**
 * Interface
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
interface BundleManifestInterface
{
    /**
     * @return array[]
     */
    public function getDefinitions(): array;
}