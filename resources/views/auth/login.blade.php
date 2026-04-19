<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-success" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h4 class="mb-4 fw-bold text-center" style="color: #f8f9fa;">Welcome Back</h4>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <!-- Remember Me -->
        <div class="mb-4 form-check">
            <input id="remember_me" type="checkbox" class="form-check-input border-secondary bg-transparent" name="remember">
            <label for="remember_me" class="form-check-label text-muted" style="font-size: 0.9rem;">{{ __('Remember me') }}</label>
        </div>

        <div class="d-flex align-items-center justify-content-between mt-4">
            @if (Route::has('password.request'))
                <a class="text-muted-link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="btn btn-primary-cta px-4">
                {{ __('Log in') }}
            </button>
        </div>
        
        <div class="mt-4 text-center">
            <p class="text-muted" style="font-size: 0.9rem;">
                Don't have an account? <a href="{{ route('register') }}" style="color: #85f43a; text-decoration: none;">Register here</a>
            </p>
        </div>
    </form>
</x-guest-layout>
