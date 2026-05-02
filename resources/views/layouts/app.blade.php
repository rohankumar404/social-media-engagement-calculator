<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <script>
        tailwind = {
            config: {
                corePlugins: {
                    preflight: false,
                }
            }
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        $activeCurrencies = \Illuminate\Support\Facades\Cache::remember('active_currencies', 3600, function() {
            return \App\Models\Currency::all();
        });
        $sysSettings = \Illuminate\Support\Facades\Cache::remember('system_settings', 3600, function() {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
        $defaultCurrencyCode = $sysSettings['system_default_currency'] ?? 'USD';
    @endphp

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('currency', {
                selected: localStorage.getItem('selected_currency') || '{{ $defaultCurrencyCode }}',
                list: @json($activeCurrencies),
                
                get current() {
                    return this.list.find(c => c.code === this.selected) || this.list.find(c => c.code === 'USD') || this.list[0];
                },

                update(code) {
                    this.selected = code;
                    localStorage.setItem('selected_currency', code);
                    // Dispatch global event for non-alpine components if needed
                    window.dispatchEvent(new CustomEvent('currency-changed', { detail: code }));
                },

                format(amount) {
                    const curr = this.current;
                    const converted = amount * curr.exchange_rate;
                    
                    // Smart Formatting: KWD Precision
                    const decimals = curr.code === 'KWD' ? 3 : 2;
                    
                    const formatted = new Intl.NumberFormat('en-US', {
                        minimumFractionDigits: decimals,
                        maximumFractionDigits: decimals,
                    }).format(converted);

                    return curr.symbol + ' ' + formatted;
                },

                convert(amount) {
                    return amount * this.current.exchange_rate;
                }
            });

            Alpine.data('globalStrategyModal', () => ({
                isStrategyModalOpen: false,
                isStrategySubmitting: false,
                strategySuccess: false,
                strategyError: false,
                strategyForm: {
                    name: '',
                    email: '',
                    phone: '',
                    company: '',
                    message: ''
                },

                async submitStrategy() {
                    this.isStrategySubmitting = true;
                    this.strategySuccess = false;
                    this.strategyError = false;

                    try {
                        const token = document.querySelector('meta[name="csrf-token"]');
                        const response = await fetch('/api/strategy-call', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
                            },
                            body: JSON.stringify(this.strategyForm)
                        });

                        if (response.ok) {
                            this.strategySuccess = true;
                            this.strategyForm = {name: '', email: '', phone: '', company: '', message: ''};
                            setTimeout(() => {
                                this.isStrategyModalOpen = false;
                                this.strategySuccess = false;
                            }, 3000);
                        } else {
                            this.strategyError = true;
                        }
                    } catch (e) {
                        this.strategyError = true;
                    } finally {
                        this.isStrategySubmitting = false;
                    }
                }
            }));
        });
    </script>
</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-100">
    <div class="min-h-screen" x-data="globalStrategyModal()" @open-strategy-modal.window="isStrategyModalOpen = true">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot ?? '' }}
            @yield('content')
        </main>

        <!-- Premium Footer -->
        <footer class="mt-auto py-5" style="background-color: #1a1a1a; border-top: 1px solid rgba(255,255,255,0.05);">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            @if(($tool_settings['white_label_active'] ?? '0') == '1' && !empty($tool_settings['custom_logo_path']))
                                <img src="{{ asset('storage/' . $tool_settings['custom_logo_path']) }}" alt="Logo" style="height: 35px;">
                            @else
                                <img src="https://mapsily.com/wp-content/uploads/2026/04/Mapsily-wihte-logo.png" alt="Logo" style="height: 35px;">
                            @endif
                        </div>
                        <p class="text-secondary small pr-lg-5" style="color: #a1a1aa !important;">
                            {{ ($tool_settings['white_label_active'] ?? '0') == '1' ? ($tool_settings['custom_client_title'] ?? 'Our Platform') : 'Mapsily' }} 
                            is a premier digital growth agency specializing in data-driven marketing strategies and creative performance solutions. This engagement intelligence tool is designed to help you decode social metrics and scale your brand.
                        </p>
                        <div class="d-flex gap-3 mt-3">
                            <a href="#" class="text-secondary" style="color: #a1a1aa !important;"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="text-secondary" style="color: #a1a1aa !important;"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" class="text-secondary" style="color: #a1a1aa !important;"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="text-secondary" style="color: #a1a1aa !important;"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-2 col-6">
                        <h6 class="text-white fw-bold mb-3">Product</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><a href="/" class="text-decoration-none" style="color: #a1a1aa !important;">Calculator</a></li>
                            <li class="mb-2"><a href="/dashboard" class="text-decoration-none" style="color: #a1a1aa !important;">Dashboard</a></li>
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">Pricing</a></li>
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">API Access</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-6">
                        <h6 class="text-white fw-bold mb-3">Resources</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">Growth Blog</a></li>
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">Case Studies</a></li>
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">Documentation</a></li>
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">Industry Stats</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <h6 class="text-white fw-bold mb-3">Support & Legal</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bi bi-envelope-fill me-2 text-primary-accent"></i>
                                <a href="mailto:{{ $tool_settings['support_email'] ?? 'support@mapsily.com' }}" class="text-decoration-none" style="color: #a1a1aa !important;">{{ $tool_settings['support_email'] ?? 'support@mapsily.com' }}</a>
                            </li>
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">Privacy Policy</a></li>
                            <li class="mb-2"><a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-decoration-none" style="color: #a1a1aa !important;">Terms of Service</a></li>
                        </ul>
                        <div class="mt-4 p-3 rounded" style="background: rgba(133, 244, 58, 0.05); border: 1px solid rgba(133, 244, 58, 0.1);">
                            <div class="text-white small fw-bold mb-1">Need help scaling?</div>
                            <p class="small mb-0" style="color: #a1a1aa !important;">Our analysts are ready to help you grow. <a href="#" @click.prevent="$dispatch('open-strategy-modal')" class="text-primary-accent fw-bold text-decoration-none">Book a call</a></p>
                        </div>
                    </div>
                </div>
                
                <hr class="my-4" style="border-color: rgba(255,255,255,0.05);">
                
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <p class="small mb-0" style="color: #a1a1aa !important;">
                        &copy; {{ date('Y') }} {{ ($tool_settings['white_label_active'] ?? '0') == '1' ? ($tool_settings['custom_client_title'] ?? 'Our Platform') : 'Mapsily' }}. All rights reserved.
                    </p>
                    <div class="d-flex gap-4 small" style="color: #a1a1aa !important;">
                        <span>Made with <i class="bi bi-heart-fill text-danger mx-1"></i> for the Creator Economy</span>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Strategy Call Modal (Global) -->
        <template x-if="isStrategyModalOpen">
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center" style="z-index: 9999;">
                <div class="position-absolute w-100 h-100 bg-black opacity-75" @click="isStrategyModalOpen = false"></div>
                <div class="position-relative p-4 p-md-5 rounded-4 shadow-lg w-100 mx-3 overflow-auto" style="max-width: 500px; max-height: 90vh; background: #1a1a1a; border: 1px solid rgba(133, 244, 58, 0.3);">
                    <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" @click="isStrategyModalOpen = false" aria-label="Close"></button>
                    
                    <h4 class="mb-2 fw-bold" style="color: #f8f9fa;">Book Free Strategy Call</h4>
                    <p class="text-secondary mb-4" style="font-size: 0.95rem;">Let us engineer a personalized strategy for your brand to scale.</p>

                    <div x-show="strategySuccess">
                        <div class="alert alert-success d-flex align-items-center mb-4" style="background: rgba(133, 244, 58, 0.1); border: 1px solid rgba(133, 244, 58, 0.3); color: #85f43a;">
                            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                            <div>Your request has been sent! We will contact you shortly.</div>
                        </div>
                    </div>

                    <div x-show="strategyError">
                        <div class="alert alert-danger d-flex align-items-center mb-4" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #ff8787;">
                            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                            <div>Something went wrong. Please try again.</div>
                        </div>
                    </div>

                    <form @submit.prevent="submitStrategy" x-show="!strategySuccess">
                        <div class="mb-3">
                            <label class="form-label" style="color: #a1a1aa; font-size: 0.9rem;">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-white" x-model="strategyForm.name" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #a1a1aa; font-size: 0.9rem;">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control text-white" x-model="strategyForm.email" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #a1a1aa; font-size: 0.9rem;">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control text-white" x-model="strategyForm.phone" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #a1a1aa; font-size: 0.9rem;">Company Name (Optional)</label>
                            <input type="text" class="form-control text-white" x-model="strategyForm.company" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
                        </div>
                        <div class="mb-4">
                            <label class="form-label" style="color: #a1a1aa; font-size: 0.9rem;">Message (Optional)</label>
                            <textarea class="form-control text-white" rows="3" x-model="strategyForm.message" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);" placeholder="Tell us about your goals..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold" :disabled="isStrategySubmitting" style="background-color: #85f43a; border-color: #85f43a; color: #1a1a1a;">
                            <span x-show="!isStrategySubmitting">Submit Request</span>
                            <span x-show="isStrategySubmitting">Submitting...</span>
                        </button>
                    </form>
                </div>
            </div>
        </template>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>