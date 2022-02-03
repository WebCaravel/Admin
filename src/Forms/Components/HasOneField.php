<?php

namespace WebCaravel\Admin\Forms\Components;

use Closure;
use Filament\Forms\Components\Field;

class HasOneField extends Field
{
    protected string $view = 'caravel-admin::forms.components.has-one-field';
    protected bool|Closure $isLabelHidden = true;
}
