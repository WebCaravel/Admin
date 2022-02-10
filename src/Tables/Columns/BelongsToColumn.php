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
            ->url(function($record) use ($name): ?string {
                $parts = explode(".", $name);
                $relName = $parts[0];
                $rel = $record->$relName;

                if($rel) {
                    $resource = Resource::makeByModel($rel);

                    return $resource->getRoute("edit", $rel);
                }

                return null;
            });
    }
}
