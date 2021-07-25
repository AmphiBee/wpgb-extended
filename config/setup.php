<?php

return [
    'hooks' => [
        'actions' => [
            \AmphiBee\WpgbExtended\Core\Hooks\SyncSavedFacet::class,
            \AmphiBee\WpgbExtended\Core\Hooks\SyncManager::class,
        ],
        'filters' => [
            \AmphiBee\WpgbExtended\Core\Hooks\ExtendedFacetArgs::class,
        ],
    ],
];
