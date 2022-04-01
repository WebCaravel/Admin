<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Field;

class ModalButtonField extends Field
{
    protected string $view = 'caravel-admin::forms.components.modal-button-field';
    public string $title = "";
    public string $modalFormClass;


    public function getModalFormClass(): string
    {
        return $this->modalFormClass;
    }


    public function modal(string $modalFormClass): static
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
