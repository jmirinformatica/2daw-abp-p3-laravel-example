<x-app-layout :box=true>
    @php
        $parentRoute = 'posts';
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>
    <!-- Results -->
    <form action="{{ route($parentRoute . '.index') }}" method="GET" class="mb-6">
        <div class="relative w-full max-w-sm">
            <x-text-input
                name="search"
                :value="$search"
                id="table-search"
                class="pl-10 w-full"
                placeholder="{{ __('Press Enter to search') }}"
            />
            <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
        </div>
    </form> 
    <div class="grid gap-6
                grid-cols-1
                sm:grid-cols-2
                lg:grid-cols-3
                xl:grid-cols-4">
        @foreach ($posts as $post)
        <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
            {{-- Imatge --}}
            @if(!empty($post->author->avatar))
            <img
                src="{{ $post->author->avatarUrl }}"
                alt="{{ $post->author->name ?? '' }}"
                class="h-48 w-full object-cover"
            >
            @endif
            <div class="p-4 flex flex-col justify-between">
                {{-- Contingut --}}
                <div class="h-24">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        {{ $post->title ?? $post->name }}
                    </h3>
                    @if(isset($post->excerpt))
                    <p class="text-sm text-gray-600 line-clamp-3">
                        {{ $post->excerpt }}
                    </p>
                    @endif
                </div>
                {{-- Accions --}}                
                <div class="mt-4 flex justify-end gap-3 text-lg">
                    @can('view', $post)
                    <a href="{{ route($parentRoute.'.show', $post) }}"
                    title="{{ __('View') }}"
                    class="text-blue-600 hover:text-blue-800">
                        👁️
                    </a>
                    @endcan
                    @can('update', $post)
                    <a href="{{ route($parentRoute.'.edit', $post) }}"
                    title="{{ __('Edit') }}"
                    class="text-yellow-600 hover:text-yellow-800">
                        ✏️
                    </a>
                    @endcan
                    @can('delete', $post)
                    <form method="POST"
                        action="{{ route($parentRoute.'.destroy', $post) }}"
                        onsubmit="return confirm('{{ __('Are you sure?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                title="{{ __('Delete') }}"
                                class="text-red-600 hover:text-red-800">
                            🗑️
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
        </div>
        @endforeach
    </div>  
    <!-- Pagination -->
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    <!-- Buttons -->
    <div class="mt-8">
        @can('create', App\Models\Post::class)
        <x-primary-button href="{{ route($parentRoute.'.create') }}">
            {{ __('Add new post') }}
        </x-primary-button>
        @endcan
        <x-secondary-button href="{{ route('dashboard') }}">
            {{ __('Back to dashboard') }}
        </x-secondary-button>
    </div>
</x-app-layout>