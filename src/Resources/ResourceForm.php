<?php

namespace WebCaravel\Admin\Resources;

use App\Models\User;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Symfony\Component\HttpFoundation\Response;
use WireUi\Traits\Actions;

abstract class ResourceForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use Actions;

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

        $this->model && $this->form->fill($this->model->toArray());
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
            if($comp instanceof \WebCaravel\Admin\Forms\Components\HasOneField) {
                $name = $comp->getName();
                $relations[$name] = $data[$name];
                unset($data[$name]);
            }
        });

        return [$data, $relations];
    }


    protected function saveRelations(array $relations): void
    {
        foreach($relations AS $key => $data) {
            // Relatio
            $rel = $this->model->$key();

            // Remove created/updated
            unset($data["created_at"], $data["updated_at"]);

            // Update or create
            isset($data["id"]) ? $rel->update($data) : $rel->create($data);
        }
    }


    public function save(): void
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

            $this->redirect($this->resource->getRoute("edit", $this->model));
        }
    }


    public function recordExists(): bool
    {
        return optional($this->model)->exists;
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

        return view('caravel-admin::resources.form', [
            "resource" => $this->resource,
            "showSaveButton" => $showSaveButton
        ]);
    }


    public function isEditable(): bool
    {
        return request()->route()->getActionMethod() !== "show";
    }
}
