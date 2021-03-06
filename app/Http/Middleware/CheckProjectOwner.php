<?php

namespace ProjectRico\Http\Middleware;

use ProjectRico\Repositories\ProjectRepository;

use Closure;


class CheckProjectOwner
{
    /**
     *
     * @var ProjectRepository
     */
    protected $repository;
    
    /**
     * 
     * @param ProjectRepository $repository
     */
    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = \Authorizer::getResourceOwnerId();
        $projectId = $request->project;
        
        if($this->repository->isOwner($projectId, $userId) == false)
        {
            return [
                'error' => 'Access Forbidden'
            ];
        }
        return $next($request);
    }
}
