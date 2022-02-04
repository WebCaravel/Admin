@php
$breadcrumbs = [
    ["label" => $resource->labelPlural(), "route" => $resource->getRoute()],
    ["label" => $model->exists ? $model->getName() : __("Neu")],
];
if($model->exists) {
    $title = $editPage ? __(':name edit', ['name' => $resource->label()]) : $resource->label();
    $title.= ': <em>' . $model->getName() . '</em>';
}
else {
    $title = __(':name add', ['name' => $resource->label()]);
}

@endphp
<x-app-layout
    :breadcrumbs="$breadcrumbs"
    :title="$title">

    <div class="py-6">
        @livewire($resource->livewire("form"), [
            "model" => $model,
            "resourceClass" => $resourceClass
        ])
    </div>
</x-app-layout>
