<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Placeholder;

class RelatedTableField extends Placeholder
{
    protected string $view = 'caravel-admin::forms.components.related-table-field';


    public function getLivewireName(): string
    {
        $class = $this->name;

        return $class::getLivewireName();
    }
}
