<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Placeholder;

class ButtonField extends Placeholder
{
    protected string $view = 'caravel-admin::forms.components.button-field';
    protected string $size = "xs";
    protected ?string $color = null;
    protected string|null $xOn = null;
    protected bool $targetBlank = false;
    protected string|\Closure|null $href = null;


    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->evaluate($this->href);
    }


    public function getContent(): ?string
    {
        return isset($this->content) ? $this->evaluate($this->content) : $this->getLabel();
    }


    public function targetBlank(bool $val = true): self
    {
        $this->targetBlank = $val;

        return $this;
    }


    public function href(string|\Closure $val): self
    {
        $this->href = $val;

        return $this;
    }


    public function isTargetBlank(): bool
    {
        return $this->targetBlank;
    }


    public function getSize(): string
    {
        return $this->size;
    }


    public function size(string $size): static
    {
        $this->size = $size;

        return $this;
    }


    public function getXOn(): ?string
    {
        return $this->xOn;
    }


    public function xOn(?string $xOn): static
    {
        $this->xOn = $xOn;

        return $this;
    }


    public function getColor(): ?string
    {
        return $this->color;
    }


    public function color(?string $color): static
    {
        $this->color = $color;

        return $this;
    }
}
