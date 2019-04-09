<?php

use function DI\create;
use function DI\get;

return [
    \AifaceTests\Stubs\StubController::class => create(
        get("request")
    )
];
