
<x-layouts::app.header>

    <div class="mx-auto max-w-3xl">

        <flux:heading size="xl">
            {{ __('ui.create_post') }}
        </flux:heading>

        <form
            method="POST"
            action="{{ route('posts.store') }}"
            class="mt-8 space-y-6"
        >
            @csrf

            <flux:field>
                <flux:label>{{ __('ui.title') }}</flux:label>

                <flux:input
                    name="title"
                    value="{{ old('title') }}"
                    maxlength="255"
                    required
                />

                <flux:error name="title" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('ui.body') }}</flux:label>

                <flux:textarea
                    name="body"
                    rows="12"
                    maxlength="1024"
                    required
                >{{ old('body') }}</flux:textarea>

                <flux:error name="body" />
            </flux:field>

            <flux:field>
                <flux:label>{{ __('ui.status') }}</flux:label>

                <flux:select name="status_id" required>
                    <flux:select.option value="">
                        {{ __('ui.select_status') }}
                    </flux:select.option>

                    @foreach ($statuses as $status)
                        <flux:select.option
                            value="{{ $status->id }}"
                            :selected="old('status_id') == $status->id"
                        >
                            {{ $status->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:error name="status_id" />
            </flux:field>

            <div class="flex flex-wrap gap-3">

                <flux:button type="submit" variant="primary">
                    {{ __('ui.create_post') }}
                </flux:button>

                <flux:button
                    href="{{ route('posts.index') }}"
                    variant="ghost"
                    wire:navigate
                >
                    {{ __('ui.cancel') }}
                </flux:button>

            </div>

        </form>

    </div>

</x-layouts::app.header>
