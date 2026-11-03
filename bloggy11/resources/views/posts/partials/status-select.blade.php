<x-input-label for="status_id" :value="__('Status')" />
<select id="status_id" name="status_id" class="block mt-1 w-full">
@foreach($statuses as $status)
    <option value="{{ $status->id }}" {{ (isset($status_id) && $status->id == $status_id) ? "selected" : "" }}>
        {{ __($status->name) }}
    </option>
@endforeach
</select>