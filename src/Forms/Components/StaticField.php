<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Component;

class StaticField extends Component
{
    protected string $view = 'caravel-admin::forms.components.static-field';
    public string|\Closure|null $label;
    public $valueOrCallback;


    public static function make($label, ?string $value = null, ?callable $callback = null, ?string $modelValue = null)
    {
        $obj = new static();
        $obj->label = $label;

        // Value
        if($value) $obj->setValue($value);
        else if($callback) $obj->setCallback($callback);
        else if($modelValue) $obj->setModelValue($modelValue);

        return $obj;
    }


    public function setValue(string $value): self
    {
        $this->valueOrCallback = $value;

        return $this;
    }


    public function setCallback(callable $callback): self
    {
        $this->valueOrCallback = $callback;

        return $this;
    }


    public function setModelValue(string $name): self
    {
        $this->valueOrCallback = function($record) use ($name) {
            return $record->$name;
        };

        return $this;
    }


    public function getValue(): ?string
    {
        if(is_callable($this->valueOrCallback)) {
            return call_user_func($this->valueOrCallback, $this->getModel());
        }
        else {
            return $this->valueOrCallback;
        }
    }
}
