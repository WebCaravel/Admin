<x-dynamic-component
    :component="$item->name"
    :tag="$item->tag"
    :color="$item->color"
    :href="$item->href"
    :onclick="$item->onClick"
    :action="$item->action">
    {{ $item->label }}
</x-dynamic-component>
