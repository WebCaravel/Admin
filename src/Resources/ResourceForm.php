<?php

namespace WebCaravel\Admin\Resources;

use App\Models\User;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use WebCaravel\Admin\Forms\Components\ButtonConfirmModalField;
use WebCaravel\Admin\Forms\Components\ButtonField;
use WireUi\Traits\Actions;

abstract class ResourceForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use Actions;

    public array $data = [];
    public string $resourceClass;
    public Model $model;
    protected Resource $resource;
    protected User $user;


    abstract protected function getFormSchema(): array;


    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->user = auth()->user();
    }


    public function booted(): void
    {
        if (! isset($this->resource)) {
            $this->resource = ($this->resourceClass)::make();
        }
    }


    public function mount(): void
    {
        if (! isset($this->resource)) {
            $this->resource = ($this->resourceClass)::make();
        }

        if($this->user->cant("view", $this->model)) {
            abort(Response::HTTP_FORBIDDEN);
        }
        if(!$this->recordExists() && $this->user->cant("create", $this->resource->model())) {
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->recordExists() ? $this->form->fill($this->model->toArray()) : $this->form->fill();
    }


    protected function getForms(): array
    {
        $schema = $this->getFormSchema();
        $form = $this->makeForm()
            ->statePath('data') // So that I don't have to define all fields in the component itself
            ->schema($schema)
            ->model($this->getFormModel());

        // If show mode: Disable all fields
        if(!$this->isEditable()) {
            $form->getComponent(function($comp){
                if(method_exists($comp, "disabled")) {
                    $comp->disabled();
                }
            });
        }

        return [
            'form' => $form
        ];
    }


    protected function getFormModel(): Model
    {
        return $this->model;
    }


    public function delete()
    {
        $this->model->deleteOrFail();
        notify(__("Deletion successful"));

        return $this->redirect($this->resource->getRoute("index"));
    }


    protected function getDataForSave(): array
    {
        $data = $this->form->getState();
        $relations = [];

        $this->form->getComponent(function($comp) use (&$data, &$relations) {
            $this->splitDataAndRelations($comp, $data, $relations);
        });

        return [$data, $relations];
    }


    protected function splitDataAndRelations(\Filament\Forms\Components\Component $component, array &$data, array &$relations): void
    {
        if($component instanceof \WebCaravel\Admin\Forms\Components\HasOneField) {
            $name = $component->getName();
            $relations[$name] = $data[$name];
            unset($data[$name]);
        }
    }


    protected function saveRelations(array $relations): void
    {
        foreach($relations AS $key => $data) {
            // Relatio
            $rel = $this->model->$key();

            if($rel instanceof HasMany) {
                $instances = [];

                foreach($data AS $row) {
                    $instances[] = $rel->newModelInstance($row);
                }

                $rel->saveMany($instances);
            }
            else {
                // Remove created/updated
                unset($data["created_at"], $data["updated_at"]);

                // Update or create
                isset($data["id"]) ? $rel->update($data) : $rel->create($data);
            }
        }
    }


    public function save($andNew = false): void
    {
        [$data, $relations] = $this->getDataForSave();

        if(optional($this->model)->exists) {
            $this->model->update($data);
            $this->saveRelations($relations);

            $this->notification()->success(__("Save successful"));
        }
        else {
            $this->model = new ($this->resource->model())($data);
            $this->model->save();
            $this->saveRelations($relations);

            // Notify
            notify(__("Creation successful"));

            $this->redirect(
                $andNew ?
                $this->resource->getRoute("create") :
                $this->resource->getRoute("edit", $this->model)
            );
        }
    }


    public function recordExists(): bool
    {
        return optional($this->model)->exists;
    }


    protected function getActionButtons(): array
    {
        $array = [];

        if($this->recordExists() && $this->user->can("delete", $this->model)) {
            $array["delete"]= ButtonConfirmModalField::make("delete")
                ->color("danger")
                ->okColor("danger")
                ->onClickJs('$wire.delete()')
                ->title(__("Delete"))
                ->body(__('Are you sure, that you want to delete this item?'))
                ->buttonLabel(__("Delete"));
        }

        if($this->recordExists() && !$this->isEditable() && $this->user->can("update", $this->model)) {
            $array["edit"]= ButtonField::make("edit")
                ->href($this->resource->getRoute('edit', $this->model))
                ->buttonLabel(__("Edit"));
        }

        return $array;
    }


    public function render(): View
    {
        $showSaveButton = false;

        if($this->isEditable()) {
            if($this->recordExists() && $this->user->can("update", $this->model)) {
                $showSaveButton = true;
            }
            elseif(!$this->recordExists() && $this->user->can("create", $this->resource->model())) {
                $showSaveButton = true;
            }
        }

        // Action buttons
        $actionButtons = $this->getActionButtons();
        foreach($actionButtons AS $key => $button) {
            $actionButtons[$key]
                ->label("")
                ->size("md")
                ->container($this->form);
        }

        return view('caravel-admin::resources.form', [
            "resource" => $this->resource,
            "actionButtons" => $actionButtons,
            "showSaveButton" => $showSaveButton
        ]);
    }


    public function isEditable(): bool
    {
        return request()->route()->getActionMethod() !== "show";
    }
}
