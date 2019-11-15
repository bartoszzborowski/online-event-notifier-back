<?php

namespace App\GraphQL;

use Illuminate\Support\Facades\Auth;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;

class sQuery extends Query
{
    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        if (isset($args['id'])) {
            return Auth::id() == $args['id'];
        }

        return true;
    }
}
