<?php

namespace WebCaravel\Admin\Forms\Components;

use Filament\Forms\Components\Concerns\BelongsToModel;
use Filament\Forms\Components\Field;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MultiCheckboxField extends Field
{
    use BelongsToModel;

    protected string $view = 'caravel-admin::forms.components.multi-checkbox-field';
    protected string $relationship;
    protected string $relatedKey;
    protected $optionsCallback = null;
    protected $optionGroups = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (self $component): void {
            $relationship = $component->getRelationship();
            $relatedModels = $relationship->getResults();

            if (!$relatedModels) {
                return;
            }

            $component->state(
                $relatedModels->pluck(
                    "id",
                    "id",
                )->toArray(),
            );
        });

        $this->dehydrated(false);
    }

    public function optionsCallback(callable $callback): self
    {
        $this->optionsCallback = $callback;

        return $this;
    }

    public function relationship(string $relationship, string $label = "name"): self
    {
        $this->relationship= $relationship;
        $this->relatedKey = $label;

        return $this;
    }

    public function saveRelationships(): void
    {
        $state = $this->getState();
        $ids = [];
        foreach($state as $id => $val) {
            if($val) {
                $ids[] = $id;
            }
        }

        $this->getRelationship()->sync($ids);
    }

    public function getRelationship(): BelongsToMany
    {
        $model = $this->getModel();

        if (is_string($model)) {
            $model = new $model();
        }

        return $model->{$this->getRelationshipName()}();
    }


    public function optionGroups(callable $callback): self
    {
        $this->optionGroups = $callback;

        return $this;
    }

    public function getOptionGroups(): ?array
    {
        return is_callable($this->optionGroups) ? call_user_func($this->optionGroups, $this->getOptions()) : null;
    }


    public function getOptions(): array
    {
        $relationship = $this->getRelationship();
        $options = $relationship
            ->getRelated()
            ->query()
            ->select("id", "name", $this->getRelatedKeyName())
            ->get();
        $label = $this->getRelatedKeyName();

        if(is_callable($this->optionsCallback)) {
            $options = call_user_func($this->optionsCallback, $options);
        }

        return $options->map(function($item) use ($label) {
            return [
                "id" => $item->id,
                "label" => $item->$label
            ];
        })->toArray();
    }


    public function isChecked(int $id): bool
    {
        return in_array($id, $this->getState());
    }


    public function getRelationshipName(): string
    {
        return $this->evaluate($this->relationship);
    }

    /**
     * Get the related key for the relationship.
     *
     * @return string
     */
    public function getRelatedKeyName()
    {
        return $this->relatedKey;
    }
}
