<?php

namespace WebCaravel\Admin\Settings;

use Filament\Forms;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Spatie\LaravelSettings\Settings;
use WireUi\Traits\Actions;

abstract class SettingsForm extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use Actions;

    public string $title;
    public array $data;
    public string $settingClass;


    public function mount(): void
    {
        $data = $this->getSettingStore()->toArray();
        $this->form->fill($data);
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


    public function save(): void
    {
        $data = $this->form->getState();
        $setting = $this->getSettingStore();

        foreach($data AS $key => $val) {
            $setting->$key = $val;
        }
        $setting->save();

        $this->notification()->success(__("Save successful"));
    }



    public function isEditable(): bool
    {
        return true;
    }


    public function render(): View
    {
        return view("caravel-admin::settings.settings-form")
            ->layoutData([
                'title' => $this->title ?? __("Settings"),
                'breadcrumbs' => []
            ]);
    }


    protected function getSettingStore(): Settings
    {
        return app($this->settingClass);
    }
}
