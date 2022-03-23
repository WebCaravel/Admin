<x-dynamic-component
    :component="$item->name"
    :tag="$item->tag"
    :color="$item->color"
    :href="$item->href"
    :action="$item->action">
    {{ $item->label }}
</x-dynamic-component>
