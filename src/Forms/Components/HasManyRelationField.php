<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Concerns;
use Filament\Forms\Components\Placeholder;
use WebCaravel\Admin\Resources\Resource;
use Illuminate\Contracts\View\View;

class HasManyRelationField extends Placeholder
{
    use Concerns\HasHelperText;
    use Concerns\HasHint;
    use Concerns\HasName;


    protected ?Resource $resource = null;
    protected string $view = 'caravel-admin::forms.components.has-many-relation-field';


    public function resource(Resource $resource): self
    {
        $this->resource = $resource;

        return $this;
    }


    /**
     * @return \WebCaravel\Admin\Resources\Resource
     */
    public function getResource(): Resource
    {
        return $this->resource;
    }


    public function render(): View
    {
        return view($this->getView(), array_merge($this->data(), [
            'component' => $this,
        ]));
    }
}
