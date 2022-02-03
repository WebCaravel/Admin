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
    protected Resource $resource;


    abstract protected function getTableColumns(): array;


    protected function getTableQuery(): Builder
    {
        return ($this->resource->model())::query();
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

        return [
            ButtonAction::make('edit')
                ->label(__("Bearbeiten"))
                ->color("primary")
                ->hidden(fn($record) => $user->cant("update", $record))
                ->url(fn($record): string => $this->resource->getRoute('edit', $record))
                ->icon('heroicon-o-pencil'),
            ButtonAction::make('delete')
                ->label(__("Löschen"))
                ->color("danger")
                ->hidden(fn($record) => $user->cant("delete", $record))
                ->icon('heroicon-o-trash')
                ->action(function ($record) {
                    $this->notification()
                        ->success(
                            __("Löschen erfolgreich"),
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
