
<x-layouts::app.header>

    <div class="mx-auto max-w-3xl">

        <div class="mb-6">
            <flux:button
                href="{{ route('posts.index') }}"
                variant="ghost"
                size="sm"
                icon="arrow-left"
                wire:navigate
            >
                {{ __('ui.back_to_posts') }}
            </flux:button>
        </div>

        {{-- Entrada --}}
        <article>

            <div class="mb-4 flex flex-wrap items-center gap-3">

                <flux:badge>
                    {{ $post->status?->name }}
                </flux:badge>

                <flux:text size="sm">
                    {{ $post->created_at->format('d/m/Y H:i') }}
                </flux:text>

            </div>

            <flux:heading size="2xl">
                {{ $post->title }}
            </flux:heading>

            <flux:text class="mt-3">
                {{ __('ui.published_by', [
                    'author' => $post->author?->name ?? __('ui.unknown_user')
                ]) }}
            </flux:text>

            <flux:separator class="my-6" />

            <div class="prose prose-zinc max-w-none whitespace-pre-line dark:prose-invert">
                {{ $post->body }}
            </div>

            @can('update', $post)
                <div class="mt-8 flex flex-wrap gap-2">

                    <flux:button
                        href="{{ route('posts.edit', $post) }}"
                        variant="outline"
                        icon="pencil"
                        wire:navigate
                    >
                        {{ __('ui.edit_entry') }}
                    </flux:button>

                    @can('delete', $post)
                        <flux:button
                            href="{{ route('posts.delete', $post) }}"
                            variant="danger"
                            icon="trash"
                            wire:navigate
                        >
                            {{ __('ui.delete_entry') }}
                        </flux:button>
                    @endcan

                </div>
            @endcan

        </article>

        {{-- Comentaris --}}
        <section class="mt-12">

            <flux:heading size="xl">
                {{ __('ui.comments') }} ({{ $post->comments_count }})
            </flux:heading>

            <flux:separator class="my-5" />

            @forelse ($post->comments as $comment)

                <div class="mb-5">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex-1">

                            <flux:text weight="medium">
                                {{ $comment->author?->name ?? __('ui.unknown_user') }}
                            </flux:text>

                            <flux:text size="xs" class="mt-1">
                                {{ $comment->created_at->format('d/m/Y H:i') }}
                            </flux:text>

                            <p class="mt-3 whitespace-pre-line">
                                {{ $comment->comment }}
                            </p>

                        </div>

                        @can('delete', $comment)
                            <form
                                method="POST"
                                action="{{ route('posts.comments.destroy', [$post, $comment]) }}"
                                onsubmit="return confirm(@js(__('ui.confirm_delete_comment')))"
                            >
                                @csrf
                                @method('DELETE')

                                <flux:button
                                    type="submit"
                                    variant="ghost"
                                    color="red"
                                    size="sm"
                                    icon="trash"
                                />
                            </form>
                        @endcan

                    </div>

                    <flux:separator class="mt-5" />

                </div>

            @empty

                <flux:text>
                    {{ __('ui.no_comments') }}
                </flux:text>

            @endforelse

            {{-- Formulari de comentaris --}}
            @auth
                @can('create', \App\Models\Comment::class)

                    <div class="mt-8">

                        <flux:heading size="lg">
                            {{ __('ui.leave_comment') }}
                        </flux:heading>

                        <form
                            method="POST"
                            action="{{ route('posts.comments.store', $post) }}"
                            class="mt-4 space-y-4"
                        >
                            @csrf

                            <flux:textarea
                                name="comment"
                                rows="3"
                                maxlength="255"
                                placeholder="{{ __('ui.write_comment') }}"
                            >{{ old('comment') }}</flux:textarea>

                            <flux:error name="comment" />

                            <flux:button type="submit" variant="primary">
                                {{ __('ui.publish_comment') }}
                            </flux:button>

                        </form>

                    </div>

                @endcan
            @else

                <flux:callout class="mt-8">
                    {{ __('ui.login_to_comment') }}

                    <div class="mt-3">
                        <flux:button
                            href="{{ route('login') }}"
                            variant="outline"
                            size="sm"
                        >
                            {{ __('ui.login') }}
                        </flux:button>
                    </div>
                </flux:callout>

            @endauth

        </section>

    </div>

</x-layouts::app.header>
