<div>
    <h2>Login with One-Time Password</h2>

    <form wire:submit="submitEmail">
        <div>
            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                wire:model="email"
                required
            >
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <button type="submit">
                Send one-time login code
            </button>
        </div>
    </form>
</div>
