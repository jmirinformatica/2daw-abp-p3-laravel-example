<x-layouts::auth>

    <h2>{{ __('contact.title') }}</h2>

    <form method="post" action="{{ route('contact.send') }}" class="mt-6 space-y-6">
        @csrf

        <flux:input
            name="name"
            :label="__('contact.name')"
            :value="old('name')"
            type="text"
            autofocus
            autocomplete="name"
            :placeholder="__('contact.placeholder.name')"
        />

        <flux:input
            name="email"
            :label="__('contact.email_address')"
            :value="old('email')"
            type="email"
            required
            autocomplete="email"
            :placeholder="__('contact.placeholder.email')"
        />

        <flux:input
            name="phone"
            :label="__('contact.phone')"
            :value="old('phone')"
            type="text"
            autocomplete="tel"
            :placeholder="__('contact.placeholder.phone')"
        />

        <flux:textarea
            name="body"
            :label="__('contact.message')"
            :value="old('body')"
            required
            :placeholder="__('contact.placeholder.message')"
        />

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full" data-test="contact-button">
                {{ __('contact.send') }}
            </flux:button>
        </div>

    </form>
    
</x-layouts::auth>