<?php

namespace WebCaravel\Admin\Resources;

use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Filament\Forms;
use WireUi\Traits\Actions;

abstract class FormModal extends Component implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;
    use Actions;

    public Model $parentRecord;
    public string $modalId;
    public array $data = [];
    public string|null $textBefore = null;
    public string|null $textAfter = null;


    abstract protected function getFormSchema(): array;


    abstract public function submit(): void;


    protected function getFormStatePath(): string
    {
        return 'data';
    }


    public function render(): View
    {
        return view('caravel-admin::resources.form-modal');
    }


    public function closeModal(): void
    {
        $this->dispatchBrowserEvent('close-modal', [
            'id' => $this->modalId,
        ]);
    }


    public function getTextBefore(): ?string
    {
        return $this->textBefore;
    }


    public function getTextAfter(): ?string
    {
        return $this->textAfter;
    }
}
