
<x-layouts::app.header>

    <div class="mx-auto max-w-3xl">

        <flux:heading size="xl">
            {{ __('ui.edit_post') }}
        </flux:heading>

        <flux:text class="mt-2">
            {{ $post->title }}
        </flux:text>

        <form
            method="POST"
            action="{{ route('posts.update', $post) }}"
            class="mt-8 space-y-6"
        >
            @csrf
            @method('PUT')

            <flux:field>
                <flux:label>{{ __('ui.title') }}</flux:label>

                <flux:input
                    name="title"
                    value="{{ old('title', $post->title) }}"
                    maxlength="255"
                />

                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('ui.body') }}</flux:label>

                <flux:textarea
                    name="body"
                    rows="12"
                    maxlength="1024"
                >{{ old('body', $post->body) }}</flux:textarea>

                <flux:error name="body" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('ui.status') }}</flux:label>

                <flux:select name="status_id">
                    @foreach ($statuses as $status)
                        <flux:select.option
                            value="{{ $status->id }}"
                            :selected="old('status_id', $post->status_id) == $status->id"
                        >
                            {{ $status->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="status_id" />
            </flux:field>

            <div class="flex flex-wrap gap-3">

                <flux:button type="submit" variant="primary">
                    {{ __('ui.save_changes') }}
                </flux:button>

                <flux:button
                    href="{{ route('posts.show', $post) }}"
                    variant="ghost"
                    wire:navigate
                >
                    {{ __('ui.cancel') }}
                </flux:button>

            </div>

        </form>

    </div>

</x-layouts::app.header>
