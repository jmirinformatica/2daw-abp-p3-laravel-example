<x-guest-layout>

    <h2>{{ __('Contact') }}</h2>

    <form method="post" action="{{ route('contact.send') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div>
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" phone="phone" type="text" class="mt-1 block w-full" autofocus autocomplete="phone" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="body" :value="__('Message')" />
            <x-textarea id="body" name="body" class="mt-1 block w-full" required />
            <x-input-error class="mt-2" :messages="$errors->get('body')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Send') }}</x-primary-button>
        </div>
    </form>

</x-guest-layout>