<?php

use Mylopotato\Aiface\Core\FastRouteAdapter;
use Mylopotato\Aiface\Core\Interfaces\Router;
use function DI\create;
use function DI\get;

return [
    Router::class => create(FastRouteAdapter::class)
        ->constructor(get("routes")),
];
