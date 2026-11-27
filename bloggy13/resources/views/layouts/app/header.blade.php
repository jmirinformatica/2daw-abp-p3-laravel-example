<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    {{-- Capçalera principal --}}
    <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        {{-- Logo / nom de l'aplicació --}}
        <x-app-logo href="{{ route('posts.index') }}" wire:navigate />

        {{-- Navegació central --}}
        <flux:navbar class="mx-auto hidden md:flex">

            <flux:navbar.item
                icon="home"
                :href="route('posts.index')"
                :current="request()->routeIs('posts.index', 'posts.show')"
                wire:navigate
            >
                {{ __('navigation.home') }}
            </flux:navbar.item>

            @auth
                @can('create', \App\Models\Post::class)
                    <flux:navbar.item
                        icon="files"
                        :href="route('posts.myIndex')"
                        :current="request()->routeIs('posts.myIndex')"
                        wire:navigate
                    >
                        {{ __('navigation.my_posts') }}
                    </flux:navbar.item>

                    <flux:navbar.item
                        icon="plus"
                        :href="route('posts.create')"
                        :current="request()->routeIs('posts.create')"
                        wire:navigate
                    >
                        {{ __('navigation.new_post') }}
                    </flux:navbar.item>
                @endcan
            @endauth

        </flux:navbar>

        <flux:spacer />

        {{-- Selector d'idioma --}}
        <div class="me-2">
            <x-language-switcher />
        </div>

        {{-- Menú d'usuari --}}
        @guest

            <div class="hidden items-center gap-2 sm:flex">
                <flux:button
                    href="{{ route('login') }}"
                    variant="ghost"
                    size="sm"
                >
                    {{ __('navigation.login') }}
                </flux:button>

                <flux:button
                    href="{{ route('register') }}"
                    variant="primary"
                    size="sm"
                >
                    {{ __('navigation.register') }}
                </flux:button>
            </div>

        @else

            <flux:dropdown position="bottom" align="end">

                <flux:button variant="ghost" icon:trailing="chevron-down">
                    {{ __('navigation.hello', ['name' => auth()->user()->name]) }}
                </flux:button>

                <flux:menu>

                    <flux:menu.item
                        href="{{ route('profile.edit') }}"
                        icon="user"
                        wire:navigate
                    >
                        {{ __('navigation.profile') }}
                    </flux:menu.item>

                    @can('create', \App\Models\Post::class)
                        <flux:menu.item
                            href="{{ route('posts.myIndex') }}"
                            icon="files"
                            wire:navigate
                        >
                            {{ __('navigation.my_posts') }}
                        </flux:menu.item>
                    @endcan

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full"
                        >
                            {{ __('navigation.logout') }}
                        </flux:menu.item>
                    </form>

                </flux:menu>

            </flux:dropdown>

        @endguest

        {{-- Menú mòbil --}}
        <flux:dropdown position="bottom" align="end" class="md:hidden">

            <flux:button variant="ghost" icon="bars-3" />

            <flux:menu>

                <flux:menu.item
                    href="{{ route('posts.index') }}"
                    icon="home"
                    wire:navigate
                >
                    {{ __('navigation.home') }}
                </flux:menu.item>

                @auth
                    @can('create', \App\Models\Post::class)
                        <flux:menu.item
                            href="{{ route('posts.myIndex') }}"
                            icon="files"
                            wire:navigate
                        >
                            {{ __('navigation.my_posts') }}
                        </flux:menu.item>

                        <flux:menu.item
                            href="{{ route('posts.create') }}"
                            icon="plus"
                            wire:navigate
                        >
                            {{ __('navigation.new_post') }}
                        </flux:menu.item>
                    @endcan
                @else
                    <flux:menu.separator />

                    <flux:menu.item href="{{ route('login') }}" icon="log-in">
                        {{ __('navigation.login') }}
                    </flux:menu.item>

                    <flux:menu.item href="{{ route('register') }}" icon="user-plus">
                        {{ __('navigation.register') }}
                    </flux:menu.item>
                @endauth

            </flux:menu>

        </flux:dropdown>

    </flux:header>

    {{-- Contingut de la pàgina --}}
    <flux:main container class="py-8">

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

        {{ $slot }}

    </flux:main>

    {{-- Notificacions Flux --}}
    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts

</body>
</html>
