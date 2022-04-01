<form wire:submit.prevent="submit">
    @if($text = $this->getTextBefore())
        <div class="pb-5">{!! $text !!}</div>
    @endif

    <div class="bg-gray-50 p-5 -mx-5">
        {{ $this->form }}
    </div>

    @if($text = $this->getTextAfter())
        <div class="pt-5">{!! $text !!}</div>
    @endif

    <div class="px-4 pt-5">
        <div class="flex flex-wrap justify-center gap-4">
            <x-caravel-admin::button x-on:click.prevent="open = false">{{ __("Cancel") }}</x-caravel-admin::button>
            <x-caravel-admin::button wire:click.prevent="submit" :color="$this->getOkColor()">{{ $this->getOkLabel() }}</x-caravel-admin::button>
        </div>
    </div>
</form>
