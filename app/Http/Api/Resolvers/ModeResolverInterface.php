<?php

namespace App\Http\Api\Resolvers;

interface ModeResolverInterface
{
    public function resolve($property, &$object, &$root, $fullPropertyPath);
}
