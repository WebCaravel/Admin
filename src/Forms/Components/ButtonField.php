<?php

namespace WebCaravel\Admin\Forms\Components;

use App\CaravelAdmin\Resources\Customer\CustomerForm;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Contracts\HasForms;
use WebCaravel\Admin\Resources\ResourceForm;

class ButtonField extends Placeholder
{
    protected string $view = 'caravel-admin::forms.components.button-field';
    protected string $size = "xs";
    protected ?string $color = null;
    protected string|null $onClickJs = null;
    protected bool $targetBlank = false;
    protected string|\Closure|null $href = null;
    protected ?string $buttonLabel;


    /**
     * @return string|null
     */
    public function getHref(): ?string
    {
        return $this->evaluate($this->href);
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


    public function getOnClickJs(): ?string
    {
        return $this->onClickJs;
    }


    public function onClickJs(?string $onClickJs): static
    {
        $this->onClickJs = $onClickJs;

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


    public function getButtonLabel(): ?string
    {
        return $this->buttonLabel ?? $this->getLabel();
    }


    public function buttonLabel(?string $buttonLabel): static
    {
        $this->buttonLabel = $buttonLabel;

        return $this;
    }
}
