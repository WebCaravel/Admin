@props([
    'trigger' => null,
    'closeEventName' => 'close-modal',
    'footer' => null,
    'title' => null,
    'body' => null,
    'id' => null,
    'actions' => null,
    'openEventName' => 'open-modal',
    'displayClasses' => 'inline-block',
    'width' => 'sm',
])

<div x-data="{ open: false }" role="dialog" aria-modal="true" class="{{ $displayClasses }}"
     @if ($id)
     x-on:{{ $closeEventName }}.window="if ($event.detail.id === '{{ $id }}') open = false"
     x-on:{{ $openEventName }}.window="if ($event.detail.id === '{{ $id }}') open = true"
    @endif
>
    {{ $trigger }}

    <div
        class="fixed inset-0 z-40 flex items-center min-h-screen p-4 overflow-y-auto"
        x-show="open"
        x-transition:enter="transition ease duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak>
        <button
            class="fixed inset-0 w-full h-full bg-black/50 focus:outline-none"
            x-on:click="open = false"
            type="button"
            aria-hidden="true"
        ></button>

        <div
            x-show="open"
            x-transition:enter="transition ease duration-300"
            x-transition:enter-start="translate-y-8"
            x-transition:enter-end="translate-y-0"
            x-transition:leave="transition ease duration-300"
            x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-8"
            x-cloak
            {{ $attributes->class([
                'relative w-full p-2 mx-auto mt-auto space-y-2 bg-white md:mb-auto mt-full rounded-xl',
                'max-w-xs' => $width === 'xs',
                'max-w-sm' => $width === 'sm',
                'max-w-md' => $width === 'md',
                'max-w-lg' => $width === 'lg',
                'max-w-xl' => $width === 'xl',
                'max-w-2xl' => $width === '2xl',
                'max-w-3xl' => $width === '3xl',
                'max-w-4xl' => $width === '4xl',
                'max-w-5xl' => $width === '5xl',
                'max-w-6xl' => $width === '6xl',
                'max-w-7xl' => $width === '7xl',
            ]) }}
        >
            <div class="space-y-2">
                @if(!empty($title))
                    <div class="p-2 space-y-1 text-center text-xl">{{ $title }}</div>
                @endif

                @if (!empty($body))
                    <div class="px-4 py-2 space-y-4">
                        {{ $body }}
                    </div>
                @endif
            </div>

            @if ($footer || $actions)
                <hr>
                <div class="px-4 py-2">
                    {{ $footer }}

                    @if(isset($actions))
                        <div class="flex flex-wrap justify-center gap-4">
                            {{ $actions }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
