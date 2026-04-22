<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h4 class="mb-4 fw-bold text-center" style="color: #f8f9fa;">Create an Account</h4>

        <div class="d-grid mb-4">
            <a href="{{ route('social.redirect', 'google') }}" class="btn btn-outline-light d-flex align-items-center justify-content-center gap-2" style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.15); font-weight: 500; padding: 0.65rem;">
                <svg width="18" height="18" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                </svg>
                Sign up with Google
            </a>
        </div>

        <div class="d-flex align-items-center mb-4">
            <hr class="flex-grow-1 border-secondary m-0">
            <span class="px-3 text-muted small">or sign up with email</span>
            <hr class="flex-grow-1 border-secondary m-0">
        </div>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus
                autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" class="form-control" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input id="password" class="form-control" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
        </div>

        <button type="submit" class="btn btn-primary-cta w-100 py-2">
            {{ __('Register') }}
        </button>

        <div class="mt-4 text-center">
            <p class="text-light" style="font-size: 0.9rem;">
                Already registered? <a href="{{ route('login') }}" style="color: #85f43a; text-decoration: none;">Log
                    in</a>
            </p>
        </div>
    </form>
</x-guest-layout>