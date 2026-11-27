
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', config('app.name'))</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @fluxAppearance
</head>
<body class="min-h-screen bg-zinc-50 dark:bg-zinc-900">

    <flux:header container class="border-b border-zinc-200 bg-white dark:border-zinc-700 dark:bg-zinc-900">

        {{-- Nom de l'aplicació --}}
        <a href="{{ route('posts.index') }}"
           class="text-lg font-bold tracking-tight whitespace-nowrap">
            {{ config('app.name') }}
        </a>

        {{-- Navegació central: escriptori --}}
        <flux:navbar class="mx-auto hidden md:flex">

            <flux:navbar.item href="{{ route('posts.index') }}">
                {{ __('Inici') }}
            </flux:navbar.item>

            @auth
                <flux:navbar.item href="{{ route('posts.myIndex') }}">
                    {{ __('Les meves entrades') }}
                </flux:navbar.item>

                @can('create', App\Models\Post::class)
                    <flux:navbar.item href="{{ route('posts.create') }}">
                        {{ __('Nova entrada') }}
                    </flux:navbar.item>
                @endcan
            @endauth

        </flux:navbar>

        <flux:spacer />

        {{-- Selector d'idioma --}}
        <div class="me-3">
            <x-language-switcher />
        </div>

        {{-- Menú d'usuari --}}
        @guest
            <div class="flex items-center gap-2">
                <flux:button href="{{ route('login') }}"
                             variant="ghost"
                             size="sm">
                    {{ __('Inicia sessió') }}
                </flux:button>

                <flux:button href="{{ route('register') }}"
                             variant="primary"
                             size="sm">
                    {{ __('Registra\'t') }}
                </flux:button>
            </div>
        @else
            <flux:dropdown position="bottom" align="end">
                <flux:button variant="ghost" icon:trailing="chevron-down">
                    {{ __('Hola, :name', ['name' => auth()->user()->name]) }}
                </flux:button>

                <flux:navmenu>
                    <flux:navmenu.item href="{{ route('posts.myIndex') }}">
                        {{ __('Les meves entrades') }}
                    </flux:navmenu.item>

                    <flux:navmenu.item href="{{ route('posts.create') }}">
                        {{ __('Nova entrada') }}
                    </flux:navmenu.item>

                    <flux:navmenu.separator />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full px-3 py-2 text-start text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800">
                            {{ __('Tanca la sessió') }}
                        </button>
                    </form>
                </flux:navmenu>
            </flux:dropdown>
        @endguest

        {{-- Menú simplificat per a mòbils --}}
        <flux:dropdown position="bottom" align="end" class="md:hidden">
            <flux:button variant="ghost" icon="bars-3" />

            <flux:navmenu>
                <flux:navmenu.item href="{{ route('posts.index') }}">
                    {{ __('Inici') }}
                </flux:navmenu.item>

                @auth
                    <flux:navmenu.item href="{{ route('posts.myIndex') }}">
                        {{ __('Les meves entrades') }}
                    </flux:navmenu.item>

                    @can('create', App\Models\Post::class)
                        <flux:navmenu.item href="{{ route('posts.create') }}">
                            {{ __('Nova entrada') }}
                        </flux:navmenu.item>
                    @endcan
                @else
                    <flux:navmenu.item href="{{ route('login') }}">
                        {{ __('Inicia sessió') }}
                    </flux:navmenu.item>

                    <flux:navmenu.item href="{{ route('register') }}">
                        {{ __('Registra\'t') }}
                    </flux:navmenu.item>
                @endauth
            </flux:navmenu>
        </flux:dropdown>

    </flux:header>

    <flux:main container class="py-8">

        {{-- Missatges de resposta --}}
        @if (session('success'))
            <flux:callout variant="success" class="mb-6">
                {{ session('success') }}
            </flux:callout>
        @endif

        @if (session('error'))
            <flux:callout variant="danger" class="mb-6">
                {{ session('error') }}
            </flux:callout>
        @endif

        @yield('content')

    </flux:main>

    @fluxScripts
</body>
</html>
