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

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- Tailwind (no preflight so Bootstrap still works) -->
    <script>tailwind = { config: { corePlugins: { preflight: false } } }</script>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @php
        $activeCurrencies = \Illuminate\Support\Facades\Cache::remember('active_currencies', 3600, function () {
            return \App\Models\Currency::all();
        });
        $sysSettings = \Illuminate\Support\Facades\Cache::remember('system_settings', 3600, function () {
            return \App\Models\Setting::pluck('value', 'key')->toArray();
        });
        $defaultCurrencyCode = $sysSettings['system_default_currency'] ?? 'USD';
    @endphp

    <!-- Alpine Currency Store -->
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
                    window.dispatchEvent(new CustomEvent('currency-changed', { detail: code }));
                },
                format(amount) {
                    const curr = this.current;
                    const converted = amount * curr.exchange_rate;
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
        });
    </script>

    <!-- Strategy Modal Styles -->
    <style>
        #strategyCallModal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            z-index: 99999;
            background: rgba(0,0,0,0.78);
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
        }
        #strategyCallModal.active { display: flex !important; }
        #strategyModal-backdrop {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
        }
        .strategy-modal-card {
            background: #1a1a1a;
            border: 1px solid rgba(133, 244, 58, 0.3);
            border-radius: 1rem;
            padding: 2.2rem;
            width: 100%;
            max-width: 520px;
            max-height: 92vh;
            overflow-y: auto;
            position: relative;
            margin: 1rem;
            z-index: 1;
        }
        .strategy-modal-card .form-control {
            background: rgba(255,255,255,0.05) !important;
            border: 1px solid rgba(255,255,255,0.15) !important;
            color: #fff !important;
            border-radius: 0.5rem;
        }
        .strategy-modal-card .form-control::placeholder { color: #6b7280 !important; }
        .strategy-modal-card .form-control:focus {
            background: rgba(255,255,255,0.08) !important;
            border-color: rgba(133, 244, 58, 0.5) !important;
            box-shadow: 0 0 0 3px rgba(133, 244, 58, 0.1) !important;
        }
        .strategy-modal-card label {
            color: #a1a1aa;
            font-size: 0.875rem;
            display: block;
            margin-bottom: 0.35rem;
        }
        .strategy-modal-card .btn-sm-submit {
            background-color: #85f43a;
            border: none;
            color: #1a1a1a;
            font-weight: 700;
            padding: 0.7rem 1rem;
            border-radius: 0.5rem;
            width: 100%;
            font-size: 1rem;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.1s;
            letter-spacing: 0.01em;
        }
        .strategy-modal-card .btn-sm-submit:hover { opacity: 0.9; transform: translateY(-1px); }
        .strategy-modal-card .btn-sm-submit:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }
        .strategy-modal-close {
            position: absolute;
            top: 1.1rem; right: 1.1rem;
            background: rgba(255,255,255,0.08);
            border: none;
            color: #fff;
            width: 34px; height: 34px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            font-size: 1rem;
            transition: background 0.2s;
        }
        .strategy-modal-close:hover { background: rgba(255,255,255,0.18); }
    </style>
</head>

<body class="font-sans antialiased text-gray-900 dark:text-gray-100">
    <div class="min-h-screen">
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
                    <!-- Brand -->
                    <div class="col-lg-4 col-md-6">
                        <div class="mb-3">
                            @if(($tool_settings['white_label_active'] ?? '0') == '1' && !empty($tool_settings['custom_logo_path']))
                                <img src="{{ asset('storage/' . $tool_settings['custom_logo_path']) }}" alt="Logo" style="height: 35px;">
                            @else
                                <img src="https://mapsily.com/wp-content/uploads/2026/04/Mapsily-wihte-logo.png" alt="Logo" style="height: 35px;">
                            @endif
                        </div>
                        <p class="text-secondary small" style="color: #a1a1aa !important;">
                            {{ ($tool_settings['white_label_active'] ?? '0') == '1' ? ($tool_settings['custom_client_title'] ?? 'Our Platform') : 'Mapsily' }}
                            is a premier digital growth agency specializing in data-driven marketing strategies and creative performance solutions.
                        </p>
                        <div class="d-flex gap-3 mt-3">
                            <a href="#" style="color: #a1a1aa !important;"><i class="bi bi-facebook"></i></a>
                            <a href="#" style="color: #a1a1aa !important;"><i class="bi bi-twitter-x"></i></a>
                            <a href="#" style="color: #a1a1aa !important;"><i class="bi bi-instagram"></i></a>
                            <a href="#" style="color: #a1a1aa !important;"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <!-- Product -->
                    <div class="col-lg-2 col-6">
                        <h6 class="text-white fw-bold mb-3">Product</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><a href="/" class="text-decoration-none" style="color: #a1a1aa !important;">Calculator</a></li>
                            <li class="mb-2"><a href="/dashboard" class="text-decoration-none" style="color: #a1a1aa !important;">Dashboard</a></li>
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">Pricing</a></li>
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">API Access</a></li>
                        </ul>
                    </div>

                    <!-- Resources -->
                    <div class="col-lg-2 col-6">
                        <h6 class="text-white fw-bold mb-3">Resources</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">Growth Blog</a></li>
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">Case Studies</a></li>
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">Documentation</a></li>
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">Industry Stats</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div class="col-lg-4 col-md-6">
                        <h6 class="text-white fw-bold mb-3">Support & Legal</h6>
                        <ul class="list-unstyled small">
                            <li class="mb-2 d-flex align-items-center">
                                <i class="bi bi-envelope-fill me-2" style="color: #85f43a;"></i>
                                <a href="mailto:{{ $tool_settings['support_email'] ?? 'support@mapsily.com' }}" class="text-decoration-none" style="color: #a1a1aa !important;">{{ $tool_settings['support_email'] ?? 'support@mapsily.com' }}</a>
                            </li>
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">Privacy Policy</a></li>
                            <li class="mb-2"><a href="#" class="text-decoration-none" style="color: #a1a1aa !important;">Terms of Service</a></li>
                        </ul>
                        <div class="mt-4 p-3 rounded" style="background: rgba(133, 244, 58, 0.05); border: 1px solid rgba(133, 244, 58, 0.1);">
                            <div class="text-white small fw-bold mb-1">Need help scaling?</div>
                            <p class="small mb-0" style="color: #a1a1aa !important;">Our analysts are ready to help you grow.
                                <a href="#" onclick="openStrategyModal(); return false;" class="fw-bold text-decoration-none" style="color: #85f43a !important;">Book a call</a>
                            </p>
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
    </div>

    <!-- ============================================================ -->
    <!--  STRATEGY CALL MODAL — Vanilla JS (bypasses Alpine scoping)  -->
    <!-- ============================================================ -->
    <div id="strategyCallModal" role="dialog" aria-modal="true" aria-labelledby="scm-title">
        <div id="strategyModal-backdrop" onclick="closeStrategyModal()"></div>
        <div class="strategy-modal-card">
            <button class="strategy-modal-close" onclick="closeStrategyModal()" aria-label="Close modal">
                <i class="bi bi-x-lg"></i>
            </button>

            <!-- Header -->
            <div class="mb-4">
                <div class="mb-1" style="color: #85f43a; font-size: 0.78rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase;">
                    <i class="bi bi-telephone-outbound me-1"></i> Free Consultation
                </div>
                <h4 id="scm-title" class="fw-bold mb-1" style="color: #f8f9fa; font-size: 1.35rem;">Book Free Strategy Call</h4>
                <p style="color: #a1a1aa; font-size: 0.9rem; margin: 0;">Let us engineer a personalized strategy for your brand to scale.</p>
            </div>

            <!-- Success message -->
            <div id="strategyModal-success" style="display:none; margin-bottom: 1rem;">
                <div class="d-flex align-items-center p-3 rounded" style="background: rgba(133, 244, 58, 0.1); border: 1px solid rgba(133, 244, 58, 0.3);">
                    <i class="bi bi-check-circle-fill me-3 fs-5" style="color: #85f43a;"></i>
                    <div style="color: #85f43a; font-weight: 500;">Your request has been sent! We'll contact you shortly.</div>
                </div>
            </div>

            <!-- Error message -->
            <div id="strategyModal-error" style="display:none; margin-bottom: 1rem;">
                <div class="d-flex align-items-center p-3 rounded" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3);">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-5" style="color: #ff8787;"></i>
                    <div style="color: #ff8787; font-weight: 500;">Something went wrong. Please try again.</div>
                </div>
            </div>

            <!-- Form -->
            <form id="strategyModal-form" onsubmit="submitStrategyForm(event)" novalidate>
                <div class="mb-3">
                    <label for="sm-name">Name <span class="text-danger">*</span></label>
                    <input type="text" id="sm-name" class="form-control" placeholder="Your full name" required>
                </div>
                <div class="mb-3">
                    <label for="sm-email">Email <span class="text-danger">*</span></label>
                    <input type="email" id="sm-email" class="form-control" placeholder="your@email.com" required>
                </div>
                <div class="mb-3">
                    <label for="sm-phone">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" id="sm-phone" class="form-control" placeholder="+1 234 567 8900" required>
                </div>
                <div class="mb-3">
                    <label for="sm-company">Company Name <span style="color: #6b7280;">(Optional)</span></label>
                    <input type="text" id="sm-company" class="form-control" placeholder="Your company">
                </div>
                <div class="mb-4">
                    <label for="sm-message">Message <span style="color: #6b7280;">(Optional)</span></label>
                    <textarea id="sm-message" class="form-control" rows="3" placeholder="Tell us about your goals..."></textarea>
                </div>
                <button type="submit" id="sm-submit" class="btn-sm-submit">
                    <span id="sm-btn-text"><i class="bi bi-send me-2"></i>Submit Request</span>
                    <span id="sm-btn-loading" style="display:none;"><i class="bi bi-hourglass-split me-2"></i>Sending...</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Strategy Modal JavaScript -->
    <script>
        function openStrategyModal() {
            var modal = document.getElementById('strategyCallModal');
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
            // Reset state
            document.getElementById('strategyModal-success').style.display = 'none';
            document.getElementById('strategyModal-error').style.display = 'none';
            document.getElementById('strategyModal-form').style.display = 'block';
            document.getElementById('sm-submit').disabled = false;
            document.getElementById('sm-btn-text').style.display = 'inline';
            document.getElementById('sm-btn-loading').style.display = 'none';
        }

        function closeStrategyModal() {
            document.getElementById('strategyCallModal').classList.remove('active');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeStrategyModal();
        });

        async function submitStrategyForm(e) {
            e.preventDefault();
            var submitBtn = document.getElementById('sm-submit');
            var btnText = document.getElementById('sm-btn-text');
            var btnLoading = document.getElementById('sm-btn-loading');
            var errorDiv = document.getElementById('strategyModal-error');
            var successDiv = document.getElementById('strategyModal-success');
            var form = document.getElementById('strategyModal-form');

            // Basic validation
            var name = document.getElementById('sm-name').value.trim();
            var email = document.getElementById('sm-email').value.trim();
            var phone = document.getElementById('sm-phone').value.trim();
            if (!name || !email || !phone) {
                errorDiv.style.display = 'block';
                errorDiv.querySelector('div:last-child').textContent = 'Please fill in all required fields.';
                return;
            }

            submitBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline';
            errorDiv.style.display = 'none';

            var payload = {
                name: name,
                email: email,
                phone: phone,
                company: document.getElementById('sm-company').value.trim(),
                message: document.getElementById('sm-message').value.trim(),
            };

            try {
                var token = document.querySelector('meta[name="csrf-token"]');
                var response = await fetch('{{ route('api.strategy-call') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token ? token.getAttribute('content') : ''
                    },
                    body: JSON.stringify(payload)
                });

                if (response.ok) {
                    form.style.display = 'none';
                    successDiv.style.display = 'block';
                    // Clear fields
                    ['sm-name','sm-email','sm-phone','sm-company','sm-message'].forEach(function(id) {
                        document.getElementById(id).value = '';
                    });
                    setTimeout(closeStrategyModal, 3500);
                } else {
                    var errorMsg = 'Something went wrong. Please try again.';
                    if (response.status === 422) {
                        var data = await response.json();
                        if (data.errors) {
                            errorMsg = Object.values(data.errors).flat().join(' ');
                        }
                    } else if (response.status === 419) {
                        errorMsg = 'Session expired. Please refresh the page.';
                    }
                    errorDiv.style.display = 'block';
                    errorDiv.querySelector('div:last-child').textContent = errorMsg;
                }
            } catch (err) {
                errorDiv.style.display = 'block';
                errorDiv.querySelector('div:last-child').textContent = 'Network error. Please check your connection.';
            } finally {
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>