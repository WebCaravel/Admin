<?php

namespace WebCaravel\Admin\Resources;

use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ButtonAction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use WireUi\Traits\Actions;

abstract class ResourceTable extends Component implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;
    use Actions;

    public bool $disableAdd = false;
    public string $resourceClass;
    public array $relationConditions = [];
    protected Resource $resource;


    abstract protected function getTableColumns(): array;


    protected function getTableQuery(): Builder
    {
        $query = ($this->resource->model())::query();

        if($this->relationConditions) {
            foreach($this->relationConditions as $key => $val) {
                $query->where($key, $val);
            }
        }

        return $query;
    }


    public function booted(): void
    {
        if (! isset($this->resource)) {
            $this->resource = ($this->resourceClass)::make();
        }

        if(auth()->user()->cant("viewAny", $this->resource->model())) {
            abort(Response::HTTP_FORBIDDEN);
        }
    }


    public function mount(): void
    {
        if (! isset($this->resource)) {
            $this->resource = ($this->resourceClass)::make();
        }
    }


    protected function getTableActions(): array
    {
        $user = auth()->user();
        $showIcons  = config("caravel-admin.tables.action_icons");
        $showLabels = config("caravel-admin.tables.action_labels");

        return [
            ButtonAction::make('view')
                ->label($showLabels ? __("Show") : "")
                ->color("secondary")
                ->hidden(fn($record) => $user->cant("view", $record))
                ->url(fn($record): string => $this->resource->getRoute('show', $record))
                ->icon($showIcons ? 'heroicon-o-eye' : ''),
            ButtonAction::make('edit')
                ->label($showLabels ? __("Edit") : '')
                ->color("primary")
                ->hidden(fn($record) => $user->cant("update", $record))
                ->url(fn($record): string => $this->resource->getRoute('edit', $record))
                ->icon($showIcons ? 'heroicon-o-pencil' : ''),
            ButtonAction::make('delete')
                ->label($showLabels ? __("Delete") : '')
                ->color("danger")
                ->hidden(fn($record) => $user->cant("delete", $record))
                ->icon($showIcons ? 'heroicon-o-trash' : '')
                ->action(function ($record) {
                    $this->notification()
                        ->success(
                            __("Deletion successful"),
                            __("\":name\" gelöscht", ["name" => $record->getName()])
                        );

                    return $record->delete();
                })
                ->requiresConfirmation(),
        ];
    }


    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('delete')
                ->label(__("Löschen"))
                ->color("danger")
                ->icon('heroicon-o-trash')
                ->hidden(fn() => auth()->user()->cant("delete", new ($this->resource->model())))
                ->action(function (Collection $records) {
                    $this->notification()
                        ->success(
                            __("Löschen erfolgreich"),
                            $records->count() > 1
                                ? __(":count Einträge gelöscht", ["count" => $records->count()])
                                : __("Ein Eintrag gelöscht")
                        );

                    return $records->each->delete();
                })
                ->requiresConfirmation()
                ->deselectRecordsAfterCompletion(),
        ];
    }


    public function render(): \Illuminate\View\View
    {
        return view('caravel-admin::resources.table', [
            "resource" => $this->resource,
            "createRoute" => ! $this->disableAdd ? $this->resource->getRoute('create') : null,
        ]);
    }
}
