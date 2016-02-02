<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;


class CheckProjectOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle($request, Closure $next)
    {
        // $userId = \Authorizer::getResourceOwnerId();
        // $projectId = $request->project;

        // if($this->repository->isOwner($projectId, $userId) == false ){
        //     return ['error'=>'Acesso não permitido'];
        // }

        return $next($request);
    }
}
