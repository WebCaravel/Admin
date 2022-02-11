@impersonating
    <div class="px-2 py-3 text-center {{ $blockClass ?? 'text-black bg-primary-300' }}">
        {{ __("Impersonating user") }} <strong>{{ auth()->user()->getName() }}</strong>

        <x-caravel-admin::button
            size="{{ $btnSize ?? 'xs' }}"
            color="{{ $btnColor ?? 'secondary' }}"
            href="{{ $route ?? route('app.impersonate.leave') }}"
            tag="a"
            class="m-2">
            {{ __("Leave") }}
        </x-caravel-admin::button>
    </div>
@endImpersonating
