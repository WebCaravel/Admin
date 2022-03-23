<?php

namespace WebCaravel\Admin\View\Components;

use Illuminate\View\Component;

class FormActionButton extends Component
{
    public string $name;
    public ?string $tag = null;
    public ?string $color = null;
    public ?string $href = null;
    public ?string $action = null;
    public ?string $label = null;


    public static function make(string $name)
    {
        $obj = new static();
        $obj->setName($name);

        return $obj;
    }


    public function render()
    {
        return view('caravel-admin::components.form-action-button', [
            "item" => $this
        ]);
    }


    /**
     * @param string $name
     * @return FormActionButton
     */
    public function setName(string $name): FormActionButton
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @param string|null $tag
     * @return FormActionButton
     */
    public function setTag(?string $tag): FormActionButton
    {
        $this->tag = $tag;

        return $this;
    }


    /**
     * @param string|null $color
     * @return FormActionButton
     */
    public function setColor(?string $color): FormActionButton
    {
        $this->color = $color;

        return $this;
    }


    /**
     * @param string|null $href
     * @return FormActionButton
     */
    public function setHref(?string $href): FormActionButton
    {
        $this->href = $href;

        return $this;
    }


    /**
     * @param string|null $action
     * @return FormActionButton
     */
    public function setAction(?string $action): FormActionButton
    {
        $this->action = $action;

        return $this;
    }


    /**
     * @param string|null $label
     * @return FormActionButton
     */
    public function setLabel(?string $label): FormActionButton
    {
        $this->label = $label;

        return $this;
    }
}
