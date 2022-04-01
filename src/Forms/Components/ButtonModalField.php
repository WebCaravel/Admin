<?php

namespace WebCaravel\Admin\Forms\Components;

use WebCaravel\Admin\Forms\Traits\ButtonModalTrait;


class ButtonModalField extends ButtonField
{
    use ButtonModalTrait;

    protected string $view = 'caravel-admin::forms.components.button-modal-field';
    protected string $modalFormClass;


    public function getLivewireName(): string
    {
        $ns = config("caravel-admin.resources.namespace");
        $class = substr($this->modalFormClass, strlen($ns));

        return config("caravel-admin.resources.prefix").str_replace("\-", ".", \Str::kebab(substr($class, 1)));
    }


    public function modalFormClass(string $modalFormClass): static
    {
        $this->modalFormClass = $modalFormClass;

        return $this;
    }
}
