<?php

namespace WebCaravel\Admin\Tables\Columns;

use WebCaravel\Admin\Resources\Resource;
use Filament\Tables\Columns\TextColumn;

class BelongsToColumn extends TextColumn
{
    public static function make(string $name): static
    {
        return parent::make($name)
            ->withAttributes(["class" => "text-primary-600"])
            ->url(function($record): string {
                $resource = Resource::makeByModel($record);
                return $resource->getRoute("edit", $record);
            });
    }
}
