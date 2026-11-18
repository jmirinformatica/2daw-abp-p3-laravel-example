<h1>{{ __('contact.new_message') }}</h1>
<p><strong>{{ __('contact.name') }}:</strong> {{ $name ?? __('contact.no_name') }}</p>
<p><strong>{{ __('contact.email') }}:</strong> {{ $email }}</p>
<p><strong>{{ __('contact.phone') }}:</strong> {{ $phone ?? __('contact.no_phone') }}</p>
<p><strong>{{ __('contact.message') }}:</strong></p>
<p>{{ $body }}</p>