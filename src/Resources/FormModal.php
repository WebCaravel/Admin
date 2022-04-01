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
    protected string|null $textBefore = null;
    protected string|null $textAfter = null;
    protected string $okLabel;
    protected string $okColor;


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


    public function getOkLabel(): string
    {
        return $this->okLabel ?? __("Ok");
    }


    public function okLabel(string $okLabel): static
    {
        $this->okLabel = $okLabel;

        return $this;
    }


    public function getOkColor(): string
    {
        return $this->okColor ?? "primary";
    }


    public function okColor(string $okColor): static
    {
        $this->okColor = $okColor;

        return $this;
    }
}
