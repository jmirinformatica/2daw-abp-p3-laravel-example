<x-app-layout :box=true>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Delete post') }}
        </h2>
    </x-slot>
    <p>{{ __("Are you sure you want to delete this post?") }}</p>
    <div class="my-6 b-1">
        <p class="font-semibold">{{ $post->title . " (id:{$post->id})" }}</p>
        <p>{!! $post->body !!}</p>
    </div>
    <form method="POST" action="{{ route('posts.destroy', $post) }}">
        @csrf
        @method("DELETE")
        <div class="mt-4">
            <x-danger-button>
                {{ __('Confirm delete') }}
            </x-danger-button>
            <x-secondary-button href="{{ route('posts.myIndex') }}">
                {{ __('Back to list') }}
            </x-secondary-button>        
        </div>
    </form>
</x-app-layout>