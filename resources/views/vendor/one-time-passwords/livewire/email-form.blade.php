<div>
    <h2>{{ __('one-time-passwords::form.title') }}</h2>

    <form wire:submit="submit" class="space-y-4">
        <div>
            <label for="password" class="block text-sm font-medium">
                {{ __('one-time-passwords::form.password_label') }}
            </label>
            <input
                type="text"
                id="one_time_password"
                wire:model="one_time_password"
                autocomplete="one-time-code"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"
            >
            @error('one_time_password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-primary-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                {{ __('one-time-passwords::form.submit_button') }}
            </button>
        </div>
    </form>
</div>
