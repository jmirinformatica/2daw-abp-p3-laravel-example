
<x-layouts::app.header>

    <div class="mx-auto max-w-xl">

        <flux:card>

            <div class="flex items-start gap-4">

                <div class="rounded-full bg-red-100 p-3 text-red-600 dark:bg-red-950">
                    <flux:icon name="exclamation-triangle" class="size-6" />
                </div>

                <div class="flex-1">

                    <flux:heading size="lg">
                        {{ __('ui.delete_post') }}
                    </flux:heading>

                    <flux:text class="mt-2">
                        {{ __('ui.confirm_delete_post') }}
                    </flux:text>

                </div>

            </div>

            <div class="my-6 rounded-lg bg-zinc-50 p-4 dark:bg-zinc-800">

                <flux:heading size="md">
                    {{ $post->title }}
                </flux:heading>

                <flux:text class="mt-2">
                    {{ $post->excerpt }}
                </flux:text>

            </div>

            <form
                method="POST"
                action="{{ route('posts.destroy', $post) }}"
                class="flex flex-wrap gap-3"
            >
                @csrf
                @method('DELETE')

                <flux:button type="submit" variant="danger">
                    {{ __('ui.yes_delete') }}
                </flux:button>

                <flux:button
                    href="{{ route('posts.show', $post) }}"
                    variant="ghost"
                    wire:navigate
                >
                    {{ __('ui.cancel') }}
                </flux:button>

            </form>

        </flux:card>

    </div>

</x-layouts::app.header>
