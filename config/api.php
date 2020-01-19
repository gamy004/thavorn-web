<?php

return [
    'parser' => [
        'select' => App\Http\Api\Parsers\SelectParser::class,
        'include' => App\Http\Api\Parsers\IncludeParser::class,
        'map' => App\Http\Api\Parsers\MapParser::class,
        'filter_group' => App\Http\Api\Parsers\FilterGroupParser::class,
        'sort' => App\Http\Api\Parsers\SortParser::class,
        'paginate' => App\Http\Api\Parsers\PaginateParser::class
    ],

    'resolver' => [
        'embed' => App\Http\Api\Resolvers\EmbedModeResolver::class,
        'ids' => App\Http\Api\Resolvers\IdsModeResolver::class,
        'sideload' => App\Http\Api\Resolvers\SideloadModeResolver::class
    ],

    'default_resolver' => 'embed'
];