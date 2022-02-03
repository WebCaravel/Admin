@php($breadcrumbs = [
    ["label" => $resource->labelPlural(), "route" => $resource->getRoute()],
    ["label" => $model->exists ? $model->getName() : __("Neu")],
])
<x-app-layout
    :breadcrumbs="$breadcrumbs"
    :title="$model->exists ?
            (__(':name bearbeiten', ['name' => $resource->label()]) . ': <em>' . $model->getName()) . '</em>' :
            __(':name hinzufügen', ['name' => $resource->label()])">

    <div class="py-6">
        @livewire($resource->livewire("form"), [
            "model" => $model,
            "resourceClass" => $resourceClass
        ])
    </div>
</x-app-layout>
