<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Field;

class ModalButtonField extends Field
{
    protected string $view = 'caravel-admin::forms.components.modal-button-field';
    public string $title = "";
    public string $modalFormClass;


    public function getLivewireName(): string
    {
        $ns = config("caravel-admin.resources.namespace");
        $class = substr($this->modalFormClass, strlen($ns));

        return config("caravel-admin.resources.prefix") . str_replace("\-", ".", \Str::kebab(substr($class, 1)));
    }


    public function modalFormClass(string $modalFormClass): static
    {
        $this->modalFormClass = $modalFormClass;

        return $this;
    }


    public function title(string $title): static
    {
        $this->title = $title;

        return $this;
    }


    public function getTitle(): string
    {
        return $this->title;
    }


    public function getModalId(): string
    {
        return "modal-" . \Str::slug($this->getName());
    }
}
