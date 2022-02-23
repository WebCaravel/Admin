<?php

namespace WebCaravel\Admin\Tables\Columns;

use WebCaravel\Admin\Resources\Resource;
use Filament\Tables\Columns\TextColumn;

class BelongsToColumn extends TextColumn
{
    public function resource(Resource|string $resource = null): static
    {
        if(is_string($resource)) {
            $resource = $resource::make();
        }

        return $this
            ->withAttributes([
                "class" => "link"
            ])
            ->url(function ($record) use ($resource): ?string  {
                $parts = explode(".", $this->name);
                $relName = $parts[0];

                if(optional($record->$relName)->exists && auth()->user()->can("view", $record->$relName)) {
                    return $resource->getRoute("show", $record->$relName);
                }

                return null;
            });
    }
}
