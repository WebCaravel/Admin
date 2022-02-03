<?php

namespace WebCaravel\Admin\Resources;

use App\Models\User;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
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

        $this->model && $this->form->fill($this->model->toArray());
    }


    protected function getForms(): array
    {
        return [
            'form' => $this->makeForm()
                ->statePath('data') // Damit ich nicht alle Formularfelder in der LiveWire Komponente definieren muss
                ->schema($this->getFormSchema())
                ->model($this->getFormModel()),
        ];
    }


    protected function getFormModel(): Model
    {
        return $this->model;
    }


    public function delete()
    {
        $this->model->deleteOrFail();
        notify(__("Löschen erfolgreich"));

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

        if($this->model && $this->model->exists) {
            $this->model->update($data);
            $this->saveRelations($relations);

            $this->notification()->success(__("Speichern erfolgreich"));
        }
        else {
            $this->model = new ($this->resource->model())($data);
            $this->model->save();
            $this->saveRelations($relations);

            // Notify
            notify(__("Anlegen erfolgreich"));

            $this->redirect($this->resource->getRoute("edit", $this->model));
        }
    }


    public function render(): View
    {
        return view('caravel-admin::resources.form', [
            "resource" => $this->resource,
        ]);
    }
}
