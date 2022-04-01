<?php

namespace WebCaravel\Admin\Forms\Components;

use WebCaravel\Admin\Forms\Traits\ButtonModalTrait;


class ButtonConfirmModalField extends ButtonField
{
    use ButtonModalTrait;

    protected string $view = 'caravel-admin::forms.components.button-confirm-field';
    protected string $body = "";


    public function getConfirmAction(): ?string
    {
        if($this->href) {
            if($this->targetBlank) {
                return "open = false; window.open('$this->href', '_blank').focus();";
            }
            else {
                return 'document.location.href = "' . $this->href . '"';
            }
        }

        return 'open = false; ' . $this->onClickJs;
    }


    public function getHref(): ?string
    {
        return null; // Needs to be overwriten
    }


    public function body(string $body): static
    {
        $this->body = $body;

        return $this;
    }


    public function getBody(): string
    {
        return $this->body;
    }


    public function getOkLabel(): string
    {
        return $this->okLabel ?? __("Ok");
    }


    public function okLabel(string $okLabel): static
    {
        $this->okLabel = $okLabel;

        return $this;
    }


    public function getOkColor(): string
    {
        return $this->okColor ?? "primary";
    }


    public function okColor(string $okColor): static
    {
        $this->okColor = $okColor;

        return $this;
    }
}
