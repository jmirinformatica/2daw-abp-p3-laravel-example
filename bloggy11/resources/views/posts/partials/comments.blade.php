<!-- Comments -->
@can('create', App\Model\Comment::class)
@if(!$post->commentedByAuthUser())
<div class="mt-8">
    <form method="POST" action="{{ route('posts.comments.store', $post) }}" class="mt-6 space-y-6">
        @csrf
        <div>
            <x-input-label for="comment" :value="__('fields.comment')" />
            <x-textarea id="comment" name="comment" class="mt-1 block w-full" :value="old('comment')" required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('comment')" />
        </div>
        <div>
            <x-primary-button type="submit">
                {{ __('Add comment') }}
            </x-primary-button>
            <x-secondary-button type="reset">
                {{ __('Reset') }}
            </x-secondary-button>
        </div>
    </form>
</div>
@endif
@endcan

@can('viewAny', App\Model\Comment::class)
<div class="mt-8">
    <ul class="list-group">
    @foreach($post->comments as $comment)
        <li class="list-group-item mb-10">
            <p><b>{{ $comment->author->name }}</b></p> 
            <p>{{ $comment->comment }}</p>
            <p>{{ $comment->created_at->format('d/m/Y') }}</p>
            @can('delete', $comment)
            <form method="POST" action="{{ route('posts.comments.destroy', [$post, $comment]) }}" class="mt-6">
                @csrf
                @method("DELETE")
                <x-danger-button>
                    {{ __('Delete comment') }}
                </x-danger-button>
            </form>
            @endcan
        </li>
    @endforeach
    </ul>
</div>
@endcan