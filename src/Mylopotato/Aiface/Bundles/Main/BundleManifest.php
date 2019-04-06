<?php

namespace Mylopotato\Aiface\Bundles\Main;

use Mylopotato\Aiface\Bundles\Main\Controllers\Main;
use Mylopotato\Aiface\Core\BundleManifestInterface;

/**
 * Definition of Main bundle
 *
 * @author Mylopotato <mylopotato@yandex.ru>
 */
class BundleManifest implements BundleManifestInterface
{
    /**
     * @inheritdoc
     */
    public function getDefinitions(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getRoutes(): array
    {
        return [
            "/" => [
                "GET POST" => Main::class . "@index",
            ],
        ];
    }
}