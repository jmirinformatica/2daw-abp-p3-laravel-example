
<x-layouts::app.header>

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <flux:heading size="xl">
                {{ $owner ? __('ui.my_posts') : __('ui.posts') }}
            </flux:heading>

            <flux:text class="mt-1">
                {{ $owner ? __('ui.manage_posts') : __('ui.latest_posts') }}
            </flux:text>
        </div>

        @auth
            @can('create', \App\Models\Post::class)
                <flux:button href="{{ route('posts.create') }}"
                             variant="primary"
                             icon="plus"
                             wire:navigate>
                    {{ __('ui.new_post') }}
                </flux:button>
            @endcan
        @endauth

    </div>

    {{-- Cercador --}}
    <form method="GET"
          action="{{ $owner ? route('posts.myIndex') : route('posts.index') }}"
          class="mb-6 flex gap-2">

        <div class="flex-1">
            <flux:input
                name="search"
                value="{{ $search }}"
                placeholder="{{ __('ui.search_placeholder') }}"
                icon="magnifying-glass"
            />
        </div>

        <flux:button type="submit" variant="outline">
            {{ __('ui.search') }}
        </flux:button>

        @if ($search)
            <flux:button
                href="{{ $owner ? route('posts.myIndex') : route('posts.index') }}"
                variant="ghost"
                wire:navigate
            >
                {{ __('ui.clear') }}
            </flux:button>
        @endif

    </form>

    {{-- Resultats --}}
    @if ($posts->isEmpty())

        <flux:card class="text-center">
            <flux:heading size="lg">
                {{ __('ui.no_posts') }}
            </flux:heading>

            <flux:text class="mt-2">
                {{ __('ui.no_posts_found') }}
            </flux:text>
        </flux:card>

    @else

        <div class="grid gap-5 md:grid-cols-2">

            @foreach ($posts as $post)

                <flux:card class="flex flex-col">

                    <div class="flex-1">

                        <div class="mb-3 flex items-center justify-between gap-3">

                            <flux:badge>
                                {{ $post->status?->name }}
                            </flux:badge>

                            <flux:text size="xs">
                                {{ $post->created_at->format('d/m/Y') }}
                            </flux:text>

                        </div>

                        <flux:heading size="lg">
                            <a href="{{ route('posts.show', $post) }}"
                               class="hover:underline"
                               wire:navigate>
                                {{ $post->title }}
                            </a>
                        </flux:heading>

                        <flux:text class="mt-3">
                            {{ $post->excerpt }}
                        </flux:text>

                    </div>

                    <flux:separator class="my-4" />

                    <div class="flex items-center justify-between gap-3">

                        <flux:text size="sm">
                            {{ __('ui.per_author', [
                                'author' => $post->author?->name ?? __('ui.unknown_user')
                            ]) }}
                        </flux:text>

                        <flux:text size="sm">
                            {{ $post->comments_count }}
                            {{ __('ui.comments_count') }}
                        </flux:text>

                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">

                        <flux:button
                            href="{{ route('posts.show', $post) }}"
                            size="sm"
                            variant="outline"
                            wire:navigate
                        >
                            {{ __('ui.read') }}
                        </flux:button>

                        @can('update', $post)
                            <flux:button
                                href="{{ route('posts.edit', $post) }}"
                                size="sm"
                                variant="ghost"
                                icon="pencil"
                                wire:navigate
                            >
                                {{ __('ui.edit') }}
                            </flux:button>
                        @endcan

                        @can('delete', $post)
                            <flux:button
                                href="{{ route('posts.delete', $post) }}"
                                size="sm"
                                variant="ghost"
                                icon="trash"
                                wire:navigate
                            >
                                {{ __('ui.delete') }}
                            </flux:button>
                        @endcan

                    </div>

                </flux:card>

            @endforeach

        </div>

        {{-- Paginació --}}
        @if ($posts instanceof \Illuminate\Contracts\Pagination\Paginator)
            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @endif

    @endif

</x-layouts::app.header>
