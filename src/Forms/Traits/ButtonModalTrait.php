<?php

namespace WebCaravel\Admin\Forms\Traits;

trait ButtonModalTrait
{
    protected string $title = "";


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
        return "modal-".\Str::slug($this->getName());
    }


    public function getOnClickJs(): ?string
    {
        return "open = true;";
    }
}
