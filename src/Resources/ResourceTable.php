<?php

namespace WebCaravel\Admin\Resources;

use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\ButtonAction;
use Filament\Tables\Actions\IconButtonAction;
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
    /**
     * @var Builder[] $extraQueries
     */
    protected array $extraQueries = [];


    abstract protected function getTableColumns(): array;


    protected function getTableBaseQuery(): Builder
    {
        return ($this->resource->model())::query();
    }


    protected function getTableQuery(): Builder
    {
        $query = $this->getTableBaseQuery();

        if($this->extraQueries) {
            foreach($this->extraQueries AS $q) {
                $query = call_user_func($q, $query);
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


    protected function getTableActionItem(string $name): IconButtonAction|ButtonAction
    {
        $showIcons  = config("caravel-admin.tables.action_icons");
        $showLabels = config("caravel-admin.tables.action_labels");

        if(!$showLabels && $showIcons) {
            return IconButtonAction::make($name);
        }
        else {
            return ButtonAction::make($name);
        }
    }


    protected function getTableActions(): array
    {
        $user = auth()->user();
        $showIcons  = config("caravel-admin.tables.action_icons");
        $showLabels = config("caravel-admin.tables.action_labels");

        return [
            $this->getTableActionItem("show")
                ->label($showLabels ? __("Show") : "")
                ->color("secondary")
                ->hidden(fn($record) => !config("caravel-admin.resources.show_view") || $user->cant("view", $record))
                ->url(fn($record): string => $this->resource->getRoute('show', $record))
                ->icon($showIcons ? 'heroicon-o-eye' : ''),
            $this->getTableActionItem("edit")
                ->label($showLabels ? __("Edit") : '')
                ->color("primary")
                ->hidden(fn($record) => $user->cant("update", $record))
                ->url(fn($record): string => $this->resource->getRoute('edit', $record))
                ->icon($showIcons ? 'heroicon-o-pencil' : ''),
            $this->getTableActionItem("delete")
                ->label($showLabels ? __("Delete") : '')
                ->color("danger")
                ->hidden(fn($record) => $user->cant("delete", $record))
                ->icon($showIcons ? 'heroicon-o-trash' : '')
                ->action(function ($record) {
                    $this->notification()
                        ->success(
                            __("Deletion successful"),
                            __("\":name\" deleted", ["name" => $record->getName()])
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
                ->label(__("Delete"))
                ->color("danger")
                ->icon('heroicon-o-trash')
                ->hidden(fn() => auth()->user()->cant("delete", new ($this->resource->model())))
                ->action(function (Collection $records) {
                    $this->notification()
                        ->success(
                            __("Deletion successfull"),
                            $records->count() > 1
                                ? __(":count entries delete", ["count" => $records->count()])
                                : __("entry deleted")
                        );

                    return $records->each->delete();
                })
                ->requiresConfirmation()
                ->deselectRecordsAfterCompletion(),
        ];
    }


    protected function getTableHeaderActions(): array
    {
        $actions = [];

        // Add button
        $actions[] = ButtonAction::make("create")
            ->url($this->resource->getRoute('create'))
            ->visible(function(){
                return !$this->disableAdd && auth()->user()->can("create", $this->resource->model());
            })
            ->label(__("Add"));

        return $actions;
    }


    public function render(): \Illuminate\View\View
    {
        return view('caravel-admin::resources.table', [
            "resource" => $this->resource,
        ]);
    }


    public static function getLivewireName(): string
    {
        $result = ["caravel-admin"];
        $ns = get_called_class();
        $parts = array_slice(explode("\\", $ns), 3);
        foreach($parts AS $part) {
            $result[] = \Str::kebab($part);
        }

        return implode(".", $result);
    }
}
