<x-guest-layout>
    <div class="mb-4 text-center">
        <h4 class="mb-2 fw-bold text-light">Verify Your Email</h4>
        <p class="text-secondary" style="font-size: 0.95rem;">
            {{ __('Please enter the 6-digit OTP code sent to your email address to continue.') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 text-success text-center fw-medium" style="font-size: 0.9rem;">
            {{ __('A new OTP code has been sent to your email address.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.verify.otp') }}">
        @csrf

        <div class="mb-4">
            <label for="otp" class="form-label text-center d-block">6-Digit Code</label>
            <input id="otp" class="form-control text-center mx-auto" type="text" name="otp" required autofocus 
                   style="max-width: 200px; font-size: 1.5rem; letter-spacing: 0.2em;" placeholder="------" maxlength="6" />
            <x-input-error :messages="$errors->get('otp')" class="mt-2 text-danger small text-center" />
        </div>

        <button type="submit" class="btn btn-primary-cta w-100 py-2">
            {{ __('Verify Code') }}
        </button>
    </form>

    <div class="mt-4 pt-3 border-top border-secondary d-flex justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted-link p-0 m-0 align-baseline">
                {{ __('Resend Code') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-muted-link p-0 m-0 align-baseline">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
