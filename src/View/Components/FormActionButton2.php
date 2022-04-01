<?php

namespace WebCaravel\Admin\View\Components;

use Illuminate\View\Component;

class FormActionButton2 extends Component
{
    public $btn;


    public static function make()
    {
        $obj = new static();

        return $obj;
    }


    public function btn($btn)
    {
        $this->btn = $btn;

        return $this;
    }


    public function render()
    {
        return view('caravel-admin::components.form-action-button2', [
            "btn" => $this->btn
        ]);
    }


    //public string $name;
    //public ?string $tag = null;
    //public ?string $color = null;
    //public ?string $href = null;
    //public ?string $action = null;
    //public ?string $label = null;
    //public ?string $onClick = null;
    //
    //
    //public static function make(string $name = "caravel-admin::button")
    //{
    //    $obj = new static();
    //    $obj->setName($name);
    //
    //    return $obj;
    //}
    //
    //
    //public function render()
    //{
    //    return view('caravel-admin::components.form-action-button', [
    //        "item" => $this
    //    ]);
    //}
    //
    //
    ///**
    // * @param string $name
    // * @return FormActionButton
    // */
    //public function setName(string $name): FormActionButton
    //{
    //    $this->name = $name;
    //
    //    return $this;
    //}
    //
    //
    ///**
    // * @param string|null $tag
    // * @return FormActionButton
    // */
    //public function setTag(?string $tag): FormActionButton
    //{
    //    $this->tag = $tag;
    //
    //    return $this;
    //}
    //
    //
    ///**
    // * @param string|null $color
    // * @return FormActionButton
    // */
    //public function setColor(?string $color): FormActionButton
    //{
    //    $this->color = $color;
    //
    //    return $this;
    //}
    //
    //
    ///**
    // * @param string|null $href
    // * @return FormActionButton
    // */
    //public function setHref(?string $href): FormActionButton
    //{
    //    $this->href = $href;
    //
    //    return $this;
    //}
    //
    //
    ///**
    // * @param string|null $action
    // * @return FormActionButton
    // */
    //public function setAction(?string $action): FormActionButton
    //{
    //    $this->action = $action;
    //
    //    return $this;
    //}
    //
    //
    ///**
    // * @param string|null $label
    // * @return FormActionButton
    // */
    //public function setLabel(?string $label): FormActionButton
    //{
    //    $this->label = $label;
    //
    //    return $this;
    //}
    //
    //
    ///**
    // * @param string|null $onClick
    // * @return FormActionButton
    // */
    //public function setOnClick(?string $onClick): FormActionButton
    //{
    //    $this->onClick = $onClick;
    //
    //    return $this;
    //}
}
