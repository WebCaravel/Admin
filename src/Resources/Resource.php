<?php

namespace WebCaravel\Admin\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Route;
use ReflectionClass;

abstract class Resource
{
    protected string $icon = "fas-file";
    protected string $model;


    public static function make(): static
    {
        return new static();
    }


    public static function makeByModel($model): ?self
    {
        $reflect = new ReflectionClass($model);

        return static::makeByShortName($reflect->getShortName());
    }


    public static function makeByShortName(string $shortName): ?self
    {
        $studly = \Str::studly($shortName);
        $class = config("caravel-admin.resources.namespace") . "\\";
        $class.= $studly.'\\'.$studly.'Resource';

        return $class ? $class::make() : null;
    }


    public static function routes($only = []): void
    {
        $obj = new static();
        $name = $obj->modelKebabCase();
        $class = config("caravel-admin.resources.controller");

        Route::resource($name, $class)->parameters([
            $name => 'modelId',
        ])->only($only ?: [
            "index", "create", "edit", "show", "destroy"
        ]);
    }


    public function label(): string
    {
        return __(\Str::singular($this->getResourceShortName()));
    }


    public function labelPlural(): string
    {
        return __(\Str::plural($this->label()));
    }


    public function icon(): string
    {
        return $this->icon;
    }


    public function model(): string
    {
        return $this->model ?? "\\App\\Models\\" . $this->getResourceShortName();
    }


    public function modelCamelCase(): string
    {
        return \Str::camel(
            \Str::plural($this->getResourceShortName())
        );
    }


    public function modelKebabCase(): string
    {
        return \Str::kebab($this->getResourceShortName());
    }


    public function getNamespace(): string
    {
        $reflect = new ReflectionClass($this);

        return $reflect->getNamespaceName();
    }


    public function getRoute(string $action = "index", $params = []): string
    {
        return route($this->getRouteName($action), $params);
    }


    public function getRouteName(string $action = "index"): string
    {
        return config("caravel-admin.resources.route_prefix").$this->modelKebabCase().".".$action;
    }


    public function getQuery(?int $id = null): Builder
    {
        $query = ($this->model())::query();

        return $id ? $query->where("id", $id) : $query;
    }


    public function livewire(string $component): string
    {
        $kebab = $this->modelKebabCase();

        return config("caravel-admin.resources.prefix").$kebab.".".$kebab.'-'.$component;
    }


    public function sidebar(?string $label = null, ?string $icon = null): array
    {
        return [
            "label" => is_string($label) ? $label : $this->labelPlural(),
            "icon" => is_string($icon) ? $icon : $this->icon(),
            "route" => $this->getRouteName(),
            "hide" => auth()->user()->cannot("viewAny", $this->model)
        ];
    }


    protected function getResourceShortName(): string
    {
        $reflect = new ReflectionClass($this);

        return preg_replace('/Resource$/', '', $reflect->getShortName());
    }
}
