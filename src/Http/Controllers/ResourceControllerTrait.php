<?php

namespace WebCaravel\Admin\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use WebCaravel\Admin\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

trait ResourceControllerTrait
{
    use AuthorizesRequests;

    protected string $resourceClass;
    protected Resource $resource;


    public function callAction($method, $parameters)
    {
        $shortName = $this->getResourceNameShort();
        $this->resource = Resource::makeByShortName($shortName);
        $this->resourceClass = ($this->resource)::class;

        return parent::callAction($method, $parameters);
    }


    public function index()
    {
        $this->authorize('viewAny', $this->resource->model());

        return view("caravel-admin::resources.index-page", $this->getViewVariables());
    }


    public function create()
    {
        $this->authorize('create', $this->resource->model());

        return view("caravel-admin::resources.form-page", $this->getViewVariables([
            "model" => new ($this->resource->model())(),
        ]));
    }


    public function edit($modelId)
    {
        $this->authorize('view', $this->resource->model());

        return view("caravel-admin::resources.form-page", $this->getViewVariables([
            "model" => $this->findModel($modelId),
        ]));
    }


    protected function findModel(string|int $modelId): Model
    {
        return $this->resource->getQuery($modelId)->firstOrFail();
    }


    protected function getViewVariables(array $merge = []): array
    {
        return array_merge([
            "resource" => $this->resource,
            "resourceClass" => $this->resourceClass,
        ], $merge);
    }


    protected function getResourceNameShort(): string
    {
        $path = request()->route()->uri();
        $parts = explode("/", $path);

        return config("caravel-admin.resources.route_prefix") ? $parts[1] : $parts[0];
    }
}
