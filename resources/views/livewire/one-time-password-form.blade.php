<div>
    <h2>{{ __('one-time-passwords::form.title') }}</h2>

    <form wire:submit="submitOneTimePassword">
        <div>
            <label for="password">
                {{ __('one-time-passwords::form.password_label') }}
            </label>
            <input
                type="text"
                id="one_time_password"
                wire:model="oneTimePassword"
            >
            @error('oneTimePassword')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit">
                {{ __('one-time-passwords::form.submit_button') }}
            </button>
        </div>
    </form>
</div>
