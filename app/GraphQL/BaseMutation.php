<?php

namespace App\GraphQL;


use App\Models\User;
use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\Request;
use Rebing\GraphQL\Support\Mutation;
use Tymon\JWTAuth\JWTAuth;

abstract class BaseMutation extends Mutation
{
    /** @var Request $request */
    protected $request;
    protected $auth;
    protected $isSecret = false;
    protected $currentUser = null;


    public function __construct()
    {
        $this->request = app(Request::class);
        $host = $this->request->header('host', 'localhost');
        $this->auth = app(JWTAuth::class);
        $this->auth->setRequest($this->request);

        if ($token = $this->auth->getToken()) {
            $this->currentUser = $this->auth->authenticate($token);
        } elseif ($host === 'localhost') {
            $this->currentUser = User::whereAdmin(true)->first();
        }
    }

    public function authorize($root, array $args, $ctx, ResolveInfo $resolveInfo = null, Closure $getSelectFields = null): bool
    {
        if ($this->isSecret && !$this->currentUser) {
            return false;
        }
        return true;
    }
}
