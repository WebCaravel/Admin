@php($resource = $getResource())
<div class="-mx-6 -my-4 relation-table-field">
    @livewire($resource->livewire("table"), [
        "resourceClass" => $resource::class
    ], key("relation-table-field_" . $resource->modelCamelCase() . "_" . $getRecord->id))
</div>
