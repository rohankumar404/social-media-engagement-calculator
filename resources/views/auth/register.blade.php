<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h4 class="mb-4 fw-bold text-center" style="color: #f8f9fa;">Create an Account</h4>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
        </div>

        <button type="submit" class="btn btn-primary-cta w-100 py-2">
            {{ __('Register') }}
        </button>

        <div class="mt-4 text-center">
            <p class="text-muted" style="font-size: 0.9rem;">
                Already registered? <a href="{{ route('login') }}" style="color: #85f43a; text-decoration: none;">Log in</a>
            </p>
        </div>
    </form>
</x-guest-layout>
