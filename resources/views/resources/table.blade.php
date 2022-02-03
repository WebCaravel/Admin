<div>
    <div class="text-right mb-6">
        @if($createRoute && auth()->user()->can("create", $resource->model()))
            <x-caravel-admin::button :href="$createRoute" color="primary" tag="a">{{ __("Hinzufügen") }}</x-caravel-admin::button>
        @endif
    </div>

    {{ $this->table }}

    <x-caravel-admin::spinner wire:loading.delay.longer />
</div>
