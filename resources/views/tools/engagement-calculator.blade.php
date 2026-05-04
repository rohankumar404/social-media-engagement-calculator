@extends('layouts.app')

@section('title', (($tool_settings['white_label_active'] ?? '0') == '1' ? ($tool_settings['custom_client_title'] ?? 'Calculator') : 'Social Media Engagement Calculator - MapsilyTools'))

@section('content')
    <style>
        /* Design Aesthetics */
        [x-cloak] {
            display: none !important;
        }

        :root {
            --color-primary:
                {{ $tool_settings['primary_color'] ?? '#85f43a' }}
            ;
            --bg-main:
                {{ $tool_settings['dark_mode_bg'] ?? '#1e1e1e' }}
            ;
            --bg-card: rgba(255, 255, 255, 0.03);
            --bg-card-hover: rgba(255, 255, 255, 0.05);
            --text-muted: #a1a1aa;
        }

        body {
            background-color: var(--bg-main) !important;
        }

        .calculator-app-wrapper-outer {
            background-color: var(--bg-main);
            color: #f8f9fa;
            -webkit-font-smoothing: antialiased;
        }

        .calculator-app-wrapper h1,
        .calculator-app-wrapper h2,
        .calculator-app-wrapper h3,
        .calculator-app-wrapper h4,
        .calculator-app-wrapper h5,
        .calculator-app-wrapper h6,
        .calculator-app-wrapper .text-light,
        .calculator-app-wrapper .text-white,
        .calculator-app-wrapper p,
        .calculator-app-wrapper label,
        .calculator-app-wrapper .form-label,
        .calculator-app-wrapper td,
        .calculator-app-wrapper th,
        .calculator-app-wrapper li,
        .calculator-app-wrapper .step-label {
            color: #f8f9fa !important;
        }

        .calculator-app-wrapper .text-muted,
        .calculator-app-wrapper .text-secondary {
            color: var(--text-muted) !important;
        }

        /* Strict Card Background Overrides */
        .card {
            background-color: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .card-header {
            background-color: transparent !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
        }

        .card-body {
            color: #f8f9fa !important;
        }

        /* Strict Form Controls */
        .form-control,
        .form-select,
        .form-range {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: rgba(255, 255, 255, 0.08) !important;
            border-color: var(--color-primary) !important;
            box-shadow: 0 0 0 0.25rem rgba(133, 244, 58, 0.25) !important;
            color: #ffffff !important;
        }

        .text-primary-accent {
            color: var(--color-primary) !important;
        }

        .page-hero {
            text-align: center;
            padding: 4rem 1rem;
            background: radial-gradient(circle at 50% 0%, rgba(133, 244, 58, 0.08) 0%, transparent 60%);
        }

        .hero-badge {
            display: inline-block;
            padding: 6px 16px;
            background: rgba(133, 244, 58, 0.1);
            color: var(--color-primary);
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border: 1px solid rgba(133, 244, 58, 0.2);
        }

        .btn-primary-cta {
            background-color: var(--color-primary);
            color: #121212;
            font-weight: 600;
            border: none;
            border-radius: 8px;
            padding: 10px 24px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 14px rgba(133, 244, 58, 0.2);
        }

        .btn-primary-cta:hover:not(:disabled) {
            background-color: #96f556;
            color: #121212;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(133, 244, 58, 0.4);
        }

        .btn-primary-cta:disabled {
            background-color: #444;
            color: #888;
            box-shadow: none;
            cursor: not-allowed;
        }

        .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.2s;
        }

        .btn-outline-light:hover {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        .card {
            background-color: var(--bg-card);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 14px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .card:hover {
            border-color: rgba(255, 255, 255, 0.1);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            padding: 1.2rem 1.5rem;
            color: #fff;
        }

        .form-control,
        .form-select {
            background-color: rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            transition: all 0.2s;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: rgba(0, 0, 0, 0.3);
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(133, 244, 58, 0.15);
            color: #fff;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.3);
        }

        .form-label {
            font-weight: 500;
            font-size: 0.9rem;
            color: #e4e4e7;
        }

        /* Progress Bar */
        .steps-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3rem;
            position: relative;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .steps-container::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 0;
            width: 100%;
            height: 3px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
            border-radius: 3px;
        }

        .steps-progress {
            position: absolute;
            top: 20px;
            left: 0;
            height: 3px;
            background: var(--color-primary);
            z-index: 1;
            transition: width 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 3px;
            box-shadow: 0 0 10px rgba(133, 244, 58, 0.5);
        }

        .step-item {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 80px;
        }

        .step-circle {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #333333;
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px auto;
            font-weight: bold;
            color: #a1a1aa;
            transition: all 0.4s ease;
        }

        .step-item.active .step-circle {
            background: var(--color-primary);
            border-color: var(--color-primary);
            color: #121212;
            box-shadow: 0 0 15px rgba(133, 244, 58, 0.4);
            transform: scale(1.1);
        }

        .step-item.completed .step-circle {
            background: rgba(133, 244, 58, 0.2);
            border-color: var(--color-primary);
            color: var(--color-primary);
        }

        .step-label {
            font-size: 0.75rem;
            color: #a1a1aa;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: color 0.3s;
        }

        .step-item.active .step-label {
            color: #fff;
        }

        /* Sidebar Styles */
        .sidebar-feature {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }

        .sidebar-feature:hover {
            background: var(--bg-card-hover);
            border-color: rgba(255, 255, 255, 0.05);
            transform: scale(1.02);
        }

        .sidebar-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: rgba(133, 244, 58, 0.1);
            color: var(--color-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .sidebar-text h5 {
            font-size: 1rem;
            margin-bottom: 4px;
            color: #fff;
        }

        .sidebar-text p {
            font-size: 0.85rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
        }

        .pro-card {
            border: 1px solid var(--color-primary);
            background: linear-gradient(145deg, rgba(39, 39, 39, 1) 0%, rgba(20, 20, 20, 1) 100%);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .pro-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(133, 244, 58, 0.1);
        }

        /* CTA Banner Styles */
        .cta-banner {
            background: linear-gradient(to right, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=2000') center/cover;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            margin-top: 4rem;
            margin-bottom: 2rem;
        }

        .cta-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 80% 50%, rgba(133, 244, 58, 0.15) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .steps-container {
                margin-bottom: 2rem;
            }

            .step-label {
                display: none;
            }

            .step-item {
                width: auto;
            }
        }
    </style>

    <div class="calculator-app-wrapper py-5 container" x-data="calculatorForm()">
        <!-- Hero Section -->
        <div class="page-hero pt-0">
            <div class="hero-badge"><i class="bi bi-calculator me-2"></i>Free Tool</div>
            <h1 class="display-5 fw-bold mb-3">Social Media <span class="text-primary-accent">Engagement
                    Calculator</span></h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px;">
                Calculate your engagement rate across Instagram, Twitter, TikTok, and LinkedIn in seconds. Track your
                growth and see how you stack up against the competition.
            </p>
        </div>

        <!-- Progress Bar -->
        <div class="steps-container">
            <!-- Width calculation: (step - 1) * 33.33% -->
            <div class="steps-progress" :style="`width: ${(step - 1) * 33.333}%`"></div>

            <div class="step-item" :class="{'active': step >= 1, 'completed': step > 1}">
                <div class="step-circle">1</div>
                <div class="step-label">Select Platform</div>
            </div>
            <div class="step-item" :class="{'active': step >= 2, 'completed': step > 2}">
                <div class="step-circle">2</div>
                <div class="step-label">Metrics</div>
            </div>
            <div class="step-item" :class="{'active': step >= 3, 'completed': step > 3}">
                <div class="step-circle">3</div>
                <div class="step-label">Advanced</div>
            </div>
            <div class="step-item" :class="{'active': step == 4}">
                <div class="step-circle">4</div>
                <div class="step-label">Details</div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="row g-4 mt-2">

            <!-- Left Column: Main Calculator Form -->
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0 fs-5"><i class="bi bi-bar-chart-steps me-2 text-primary-accent"></i> Calculator
                            Setup</h4>
                        <span class="badge bg-dark border border-secondary text-light">Step <span x-text="step"></span> of
                            4</span>
                    </div>
                    <div class="card-body p-4">
                        <form action="#" method="POST" @submit.prevent>
                            @csrf

                            <!-- Step 1: Platform Selection -->
                            <div x-show="step === 1" x-transition.opacity.duration.300ms>
                                <h5 class="mb-4">1. Choose your platform</h5>
                                <div class="mb-4">
                                    <label class="form-label">Platform</label>
                                    <select class="form-select form-select-lg" x-model="platform">
                                        <option value="" disabled>Select a platform</option>
                                        <option value="Instagram">Instagram</option>
                                        <option value="Facebook">Facebook</option>
                                        <option value="LinkedIn">LinkedIn</option>
                                        <option value="Twitter">Twitter (X)</option>
                                        <option value="YouTube">YouTube</option>
                                        <option value="TikTok">TikTok</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Step 2: Basic Metrics -->
                            <div x-show="step === 2" x-transition.opacity.duration.300ms style="display: none;">
                                <h5 class="mb-4">2. Enter basic metrics</h5>
                                <div class="mb-4">
                                    <label class="form-label">Followers / Subscribers</label>
                                    <input type="number" class="form-control form-control-lg" x-model="followers"
                                        placeholder="e.g. 15000">
                                </div>

                                <label class="form-label d-flex justify-content-between align-items-center">
                                    Total Interactions
                                    <span class="badge bg-secondary text-light fw-normal px-2 py-1"
                                        style="font-size:0.75rem;">Last Post</span>
                                </label>
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-6">
                                        <label class="form-label text-muted" style="font-size: 0.85rem">Likes</label>
                                        <input type="number" class="form-control" x-model="likes" placeholder="0">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label text-muted" style="font-size: 0.85rem">Comments</label>
                                        <input type="number" class="form-control" x-model="comments" placeholder="0">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label text-muted" style="font-size: 0.85rem">Shares</label>
                                        <input type="number" class="form-control" x-model="shares" placeholder="0">
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="form-label text-muted" style="font-size: 0.85rem">Total Posts
                                            (Optional)</label>
                                        <input type="number" class="form-control" x-model="posts" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Advanced Inputs -->
                            <div x-show="step === 3" x-transition.opacity.duration.300ms style="display: none;">
                                <h5 class="mb-4">3. Advanced Details</h5>

                                <div class="row g-3 mb-4">
                                    <!-- Instagram specific -->
                                    <div class="col-sm-6" x-show="platform === 'Instagram'">
                                        <label class="form-label">Saves</label>
                                        <input type="number" class="form-control" x-model="saves" placeholder="0">
                                    </div>

                                    <!-- YouTube / TikTok specific -->
                                    <div class="col-sm-6" x-show="platform === 'YouTube' || platform === 'TikTok'">
                                        <label class="form-label">Views</label>
                                        <input type="number" class="form-control" x-model="views" placeholder="0">
                                    </div>

                                    <!-- All -->
                                    <div class="col-sm-6">
                                        <label class="form-label">Reach <span class="text-muted fw-normal"
                                                style="font-size: 0.8rem;">(Optional)</span></label>
                                        <input type="number" class="form-control" x-model="reach" placeholder="0">
                                    </div>
                                </div>
                            </div>

                            <!-- Step 4: Industry & Content Type -->
                            <div x-show="step === 4" x-transition.opacity.duration.300ms style="display: none;">
                                <h5 class="mb-4">4. Industry & Content</h5>
                                <div class="mb-4">
                                    <label class="form-label">Industry</label>
                                    <select class="form-select" x-model="industry">
                                        <option value="" disabled>Select your industry</option>
                                        <option value="Real Estate">Real Estate</option>
                                        <option value="E-commerce">E-commerce</option>
                                        <option value="Healthcare">Healthcare</option>
                                        <option value="Education">Education</option>
                                        <option value="Personal Brand">Personal Brand</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label d-flex justify-content-between">
                                        Content Split (%)
                                        <small x-show="totalSplit !== 100 && totalSplit > 0"
                                            class="text-warning fw-normal">Total: <span x-text="totalSplit"></span>%</small>
                                    </label>
                                    <div class="row g-3">
                                        <div class="col-6 col-sm-3">
                                            <label class="form-label text-muted" style="font-size:0.8rem">Reels</label>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                x-model.number="splitReels" placeholder="0">
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <label class="form-label text-muted" style="font-size:0.8rem">Images</label>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                x-model.number="splitImages" placeholder="0">
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <label class="form-label text-muted" style="font-size:0.8rem">Carousel</label>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                x-model.number="splitCarousel" placeholder="0">
                                        </div>
                                        <div class="col-6 col-sm-3">
                                            <label class="form-label text-muted" style="font-size:0.8rem">Video</label>
                                            <input type="number" class="form-control form-control-sm text-center"
                                                x-model.number="splitVideo" placeholder="0">
                                        </div>
                                    </div>
                                </div>

                                <hr class="border-secondary opacity-25 mt-4 mb-4">
                                <h5 class="mb-3">Competitor Comparison <span class="text-muted fw-normal"
                                        style="font-size: 0.9rem;">(Optional)</span></h5>
                                <div class="row g-3 mb-4">
                                    <div class="col-sm-4">
                                        <label class="form-label text-muted" style="font-size:0.85rem">Competitor
                                            Name</label>
                                        <input type="text" class="form-control" x-model="compName"
                                            placeholder="e.g. Brand X">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label text-muted" style="font-size:0.85rem">Followers</label>
                                        <input type="number" class="form-control" x-model.number="compFollowers"
                                            placeholder="0">
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label text-muted" style="font-size:0.85rem">Engagement Rate
                                            (%)</label>
                                        <input type="number" class="form-control" x-model.number="compRate" step="0.01"
                                            placeholder="0.00">
                                    </div>
                                </div>
                            </div>

                            <hr class="border-secondary opacity-25 mt-5 mb-4">

                            <div class="d-flex justify-content-between align-items-center">
                                <!-- Show generic left button if not on step 1 -->
                                <button type="button" class="btn text-muted fw-medium px-0" x-show="step > 1"
                                    @click="step--">
                                    <i class="bi bi-arrow-left me-1"></i> Previous
                                </button>
                                <!-- Spacer when Previous is hidden -->
                                <div x-show="step === 1"></div>

                                <button type="button" class="btn btn-primary-cta px-4" x-show="step < 4" @click="step++"
                                    :disabled="!canProceed()">
                                    Next <i class="bi bi-arrow-right ms-2"></i>
                                </button>

                                <button type="button" class="btn btn-primary-cta px-4" x-show="step === 4"
                                    @click="submitCalculate" :disabled="!canSubmit() || isCalculating">
                                    <span x-show="!isCalculating">Calculate Engagement <i
                                            class="bi bi-magic ms-2"></i></span>
                                    <span x-show="isCalculating">Calculating... <span
                                            class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span></span>
                                </button>
                            </div>

                            <!-- Guest Error Limit Reached -->
                            <div x-show="errorMode" x-cloak class="alert alert-danger mt-4 border border-danger p-4"
                                style="background-color: rgba(220, 53, 69, 0.1); color: #ff6b6b;">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-x-circle-fill fs-4 me-3"></i>
                                    <div>
                                        <strong>Calculation Blocked!</strong> <span x-text="errorMsg"></span>
                                    </div>
                                </div>
                                <!-- Provide a fallback action button for the user to reset or bypass easily -->
                                <div class="mt-2" x-show="errorMode">
                                    <button type="button" class="btn btn-outline-danger btn-sm px-3" @click="resetError">Try
                                        Again Later</button>
                                    <a href="/register" class="btn btn-danger btn-sm px-3 ms-2">Upgrade Now</a>
                                </div>
                            </div>

                            <!-- Fake Engagement Warning Card -->
                            <!-- Old single fake engagement card removed in favor of Grid layout below -->

                            <!-- Calculation Results Grid -->
                            <div x-show="hasResults && !isCalculating" x-transition.opacity.duration.500ms class="mt-5">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="mb-0 text-light"><i class="bi bi-stars text-primary-accent me-2"></i> Your
                                        Engagement Report</h4>
                                    <button type="button" class="btn btn-outline-light btn-sm" @click="startPdfDownload">
                                        <span x-show="!isExporting"><i
                                                class="bi bi-file-earmark-pdf-fill text-danger me-1"></i> Export PDF</span>
                                        <span x-show="isExporting">Exporting... <span
                                                class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span></span>
                                    </button>
                                </div>

                                <div class="row g-4">
                                    <!-- Engagement Rate Card -->
                                    <div class="col-md-6">
                                        <div class="card h-100 mb-0"
                                            style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                            <div
                                                class="card-body text-center d-flex flex-column justify-content-center py-5">
                                                <h6 class="text-muted fw-normal text-uppercase letter-spacing-1 mb-3"><i
                                                        class="bi bi-activity text-primary-accent me-2"></i> Engagement Rate
                                                </h6>
                                                <h2 class="display-3 fw-bold text-light mb-0" x-text="resultEr + '%'"></h2>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quality Score Card -->
                                    <div class="col-md-6">
                                        <div class="card h-100 mb-0"
                                            style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                            <div
                                                class="card-body text-center d-flex flex-column justify-content-center py-5">
                                                <h6 class="text-muted fw-normal text-uppercase letter-spacing-1 mb-3"><i
                                                        class="bi bi-award text-primary-accent me-2"></i> Quality Score</h6>
                                                <h2 class="display-5 fw-bold mb-0" :class="getScoreColorClass(resultScore)"
                                                    x-text="resultScore"></h2>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Industry Benchmark -->
                                    <div class="col-md-6" x-show="!isLimitedMode && hasBenchmark">
                                        <div class="card h-100 mb-0"
                                            :style="`border-top: 3px solid ${benchmarkColor}; background-color: var(--bg-card); border-left: 1px solid rgba(255,255,255,0.05); border-right: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05);`">
                                            <div class="card-body">
                                                <h6 class="text-muted mb-3"><i
                                                        class="bi bi-bar-chart-fill text-primary-accent me-2"></i> Industry
                                                    Benchmark</h6>
                                                <h5 class="text-light lh-base mt-2" x-text="benchmarkMessage"></h5>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Real recommendations / insights -->
                                    <div class="col-md-6" x-show="!isLimitedMode">
                                        <div class="card h-100 mb-0"
                                            style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                            <div class="card-body">
                                                <h6 class="text-muted mb-3"><i
                                                        class="bi bi-lightbulb-fill text-primary-accent me-2"></i>
                                                    Recommendations</h6>
                                                <ul class="text-light mt-2 mb-0 ps-3"
                                                    style="font-size: 0.95rem; opacity: 0.9;">
                                                    <template x-for="rec in resultRecommendations">
                                                        <li class="mb-2" x-text="rec"></li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- What to post next -->
                                    <div class="col-md-6" x-show="!isLimitedMode && hasPostNext">
                                        <div class="card h-100 mb-0"
                                            style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                            <div class="card-body">
                                                <h6 class="text-muted"><i
                                                        class="bi bi-collection-play-fill text-primary-accent me-2"></i>
                                                    What To Post Next</h6>
                                                <div class="mt-3">
                                                    <template x-for="item in postNextArray">
                                                        <div class="d-flex align-items-start mb-2">
                                                            <i
                                                                class="bi bi-check-circle-fill text-primary-accent me-2 mt-1"></i>
                                                            <span class="text-light"
                                                                style="font-size: 0.95rem; opacity: 0.9;"
                                                                x-text="item"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fake Engagement Warning -->
                                    <div class="col-md-6" x-show="hasFakeEngagement">
                                        <div class="card h-100 mb-0"
                                            style="background-color: var(--bg-main); border: 1px solid var(--color-primary);">
                                            <div class="card-body">
                                                <h6 class="text-primary-accent fw-bold"><i
                                                        class="bi bi-shield-exclamation me-2"></i> Engagement Pattern Notice
                                                </h6>
                                                <ul class="text-light mt-3 mb-0 ps-3"
                                                    style="font-size: 0.95rem; opacity: 0.9;">
                                                    <template x-for="msg in fakeMessages">
                                                        <li class="mb-2 text-white" x-text="msg"></li>
                                                    </template>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Competitor Comparison Card -->
                            <div x-show="hasResults && hasCompetitorData && !isLimitedMode" x-cloak class="card mt-4"
                                style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                <div class="card-body">
                                    <h5 class="text-light mb-3"><i class="bi bi-people-fill text-primary-accent me-2"></i>
                                        Competitor Analysis</h5>

                                    <div class="table-responsive mb-3">
                                        <table class="table table-dark table-bordered mb-0"
                                            style="background-color: var(--bg-main);">
                                            <thead>
                                                <tr>
                                                    <th>Metric</th>
                                                    <th>You</th>
                                                    <th x-text="compResultName || 'Competitor'"></th>
                                                    <th>Difference</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Followers</td>
                                                    <td x-text="youFollowers"></td>
                                                    <td x-text="compResultFollowers"></td>
                                                    <td :class="followersDiff > 0 ? 'text-success' : 'text-danger'"
                                                        x-text="(followersDiff > 0 ? '+' : '') + followersDiff"></td>
                                                </tr>
                                                <tr>
                                                    <td>Engagement Rate</td>
                                                    <td x-text="youRate + '%'"></td>
                                                    <td x-text="compResultRate + '%'"></td>
                                                    <td :class="rateDiff > 0 ? 'text-success' : 'text-danger'"
                                                        x-text="(rateDiff > 0 ? '+' : '') + rateDiff + '%'"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="p-3 rounded bg-dark border"
                                        style="border-color: var(--color-primary) !important;">
                                        <p class="mb-0 fw-bold text-primary-accent" x-text="compMessage"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Engagement Growth Simulator Card -->
                            <div x-show="hasResults && step === 4" x-transition class="card mt-4"
                                style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                <div class="card-body">
                                    <h5 class="text-light mb-3"><i
                                            class="bi bi-graph-up-arrow text-primary-accent me-2"></i> Engagement Growth
                                        Simulator</h5>
                                    <p class="text-muted" style="font-size: 0.9rem;">Estimate your growth after 3 months by
                                        adjusting your target monthly posting frequency and engagement rate.</p>

                                    <div class="mb-4 mt-4">
                                        <label class="form-label d-flex justify-content-between text-light">
                                            <span>Posting Frequency (Posts/Month)</span>
                                            <span class="fw-bold text-primary-accent"
                                                x-text="simFrequency + ' posts'"></span>
                                        </label>
                                        <input type="range" class="form-range" min="1" max="90"
                                            x-model.number="simFrequency">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label d-flex justify-content-between text-light">
                                            <span>Target Engagement Rate (%)</span>
                                            <span class="fw-bold text-primary-accent" x-text="simRate + '%'"></span>
                                        </label>
                                        <input type="range" class="form-range" min="0.1" max="15" step="0.1"
                                            x-model.number="simRate">
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-6">
                                            <div class="p-3 rounded bg-dark border text-center"
                                                style="border-color: rgba(255,255,255,0.1) !important;">
                                                <div class="text-muted mb-1" style="font-size: 0.8rem;">Est. Followers (3
                                                    Months)</div>
                                                <h4 class="text-primary-accent fw-bold mb-0"
                                                    x-text="Math.floor(simFutureFollowers).toLocaleString()"></h4>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="p-3 rounded bg-dark border text-center"
                                                style="border-color: rgba(255,255,255,0.1) !important;">
                                                <div class="text-muted mb-1" style="font-size: 0.8rem;">Est. Interactions (3
                                                    Months)</div>
                                                <h4 class="text-primary-accent fw-bold mb-0"
                                                    x-text="Math.floor(simFutureEngagement).toLocaleString()"></h4>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Investment Breakdown (Multi-Currency Demo) -->
                                    <div class="mt-4 p-4 rounded"
                                        style="background: rgba(133, 244, 58, 0.05); border: 1px dashed rgba(133, 244, 58, 0.2);">
                                        <h6 class="text-light fw-bold mb-3 d-flex justify-content-between">
                                            <span><i class="bi bi-cash-stack me-2"></i> Investment Breakdown</span>
                                            <span class="badge bg-primary-accent text-dark"
                                                style="background-color: var(--color-primary) !important;">Recalculated in
                                                <span x-text="$store.currency.selected"></span></span>
                                        </h6>
                                        <div class="row g-3 text-muted" style="font-size: 0.9rem;">
                                            <div class="col-6 d-flex justify-content-between border-bottom pb-2"
                                                style="border-color: rgba(255,255,255,0.05) !important;">
                                                <span>Content Creation (Est)</span>
                                                <span class="text-white fw-bold"
                                                    x-text="$store.currency.format(simFrequency * 50)"></span>
                                            </div>
                                            <div class="col-6 d-flex justify-content-between border-bottom pb-2"
                                                style="border-color: rgba(255,255,255,0.05) !important;">
                                                <span>Ad Spend (Est)</span>
                                                <span class="text-white fw-bold"
                                                    x-text="$store.currency.format(simFrequency * 20)"></span>
                                            </div>
                                            <div class="col-12 mt-3 text-center">
                                                <div class="text-muted small mb-1">Total Monthly Investment</div>
                                                <h3 class="text-white fw-bold"
                                                    x-text="$store.currency.format(simFrequency * 70)"></h3>
                                                <div class="text-primary-accent fw-bold mt-2" style="font-size: 0.85rem;">
                                                    <i class="bi bi-cpu me-1"></i> ROI Estimation:
                                                    <span
                                                        x-text="(simFutureEngagement / (simFrequency * 70 * 3)).toFixed(2)"></span>
                                                    interactions per <span x-text="$store.currency.current.symbol"></span>
                                                    invested
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Visual Analytics Card -->
                            <div x-show="hasResults && step === 4 && !isLimitedMode" x-transition class="card mt-4"
                                style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                <div class="card-body">
                                    <h5 class="text-light mb-4"><i
                                            class="bi bi-pie-chart-fill text-primary-accent me-2"></i> Visual Analytics</h5>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="p-3 rounded border"
                                                style="background-color: #333333; border-color: rgba(255,255,255,0.05) !important;">
                                                <h6 class="text-muted text-center mb-3" style="font-size:0.85rem">Engagement
                                                    vs Industry Average</h6>
                                                <div style="position: relative; height:220px;">
                                                    <canvas id="engagementBarChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="p-3 rounded border"
                                                style="background-color: #333333; border-color: rgba(255,255,255,0.05) !important;">
                                                <h6 class="text-muted text-center mb-3" style="font-size:0.85rem">Monthly
                                                    Growth Projection</h6>
                                                <div style="position: relative; height:220px;">
                                                    <canvas id="growthLineChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>



            <!-- Right Column: Sidebar -->
            <div class="col-lg-4">

                <!-- Information Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 fs-6">Why use this tool?</h5>
                    </div>
                    <div class="card-body">
                        <div class="sidebar-feature">
                            <div class="sidebar-icon">
                                <i class="bi bi-lightning-charge"></i>
                            </div>
                            <div class="sidebar-text">
                                <h5>Quick Insights</h5>
                                <p>Instantly understand how well your content resonates with your audience.</p>
                            </div>
                        </div>

                        <div class="sidebar-feature">
                            <div class="sidebar-icon">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <div class="sidebar-text">
                                <h5>Track Growth</h5>
                                <p>Measure your performance over time by saving your historical data.</p>
                            </div>
                        </div>

                        <div class="sidebar-feature mb-0">
                            <div class="sidebar-icon">
                                <i class="bi bi-bullseye"></i>
                            </div>
                            <div class="sidebar-text">
                                <h5>Benchmark</h5>
                                <p>Compare your rates against industry standards and competitors.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upgrade / PRO Card -->
                <div class="card pro-card text-center position-relative overflow-hidden">
                    <div class="position-absolute top-0 end-0 bg-primary text-dark px-3 py-1 fw-bold"
                        style="border-bottom-left-radius: 12px; font-size: 0.8rem; background-color: var(--color-primary) !important;">
                        PRO</div>
                    <div class="card-body p-4">
                        <div class="mb-3 mt-2">
                            <i class="bi bi-rocket-takeoff text-primary-accent" style="font-size: 2.5rem;"></i>
                        </div>
                        <h4 class="fw-bold mb-3 fs-5">Upgrade to Pro</h4>
                        <p class="text-muted mb-4" style="font-size: 0.9rem;">
                            Unlock bulk analysis, competitor benchmarking, historical tracking, and export your reports.
                        </p>
                        <ul class="list-unstyled text-start text-muted mb-4" style="font-size: 0.9rem;">
                            <li class="mb-2"><i class="bi bi-check2-circle text-primary-accent me-2 fs-5 align-middle"></i>
                                Connect accounts directly</li>
                            <li class="mb-2"><i class="bi bi-check2-circle text-primary-accent me-2 fs-5 align-middle"></i>
                                PDF / CSV Exporting</li>
                            <li class="mb-2"><i class="bi bi-check2-circle text-primary-accent me-2 fs-5 align-middle"></i>
                                White-label reports</li>
                        </ul>
                        <a href="#" onclick="openStrategyModal(); return false;" class="btn btn-primary-cta w-100">Get Pro for <span x-text="$store.currency.format(9)"></span>/mo</a>
                    </div>
                </div>

            </div>

        </div>

        <!-- CTA Banner Module (Responsive & Animated) -->
        <div class="cta-banner p-4 p-md-5 mb-5 shadow-lg text-center" x-data>
            <div class="position-relative z-index-1">
                <div class="mb-3 d-inline-block p-2 rounded-circle"
                    style="background: rgba(133, 244, 58, 0.1); border: 1px solid rgba(133, 244, 58, 0.3);">
                    <i class="bi bi-graph-up-arrow fs-2 text-primary-accent"></i>
                </div>

                <h2 class="display-6 fw-bold text-white mb-3 tracking-tight">Need better engagement? <br
                        class="d-none d-md-block"> Let
                    {{ ($tool_settings['white_label_active'] ?? '0') == '1' ? ($tool_settings['custom_client_title'] ?? 'Our Team') : 'Mapsily' }}
                    grow your brand.
                </h2>
                <p class="lead text-muted mx-auto mb-4" style="max-width: 600px;">
                    Stop guessing what works. Our advanced growth analysts map your metrics directly against aggressive
                    industry benchmarks building a personalized strategy engineered for scale.
                </p>

                <div class="d-flex flex-column flex-sm-row justify-content-center gap-3 mt-4">
                    <a href="#" onclick="openStrategyModal(); return false;" class="btn btn-primary-cta btn-lg px-5">
                        <i class="bi bi-telephone-outbound me-2"></i> Book Free Strategy Call
                    </a>
                    <a href="/register" class="btn btn-outline-light btn-lg px-5">
                        <i class="bi bi-rocket-takeoff me-2 text-primary-accent"></i> Upgrade to Premium
                    </a>
                </div>
            </div>
        </div>

        <!-- Modals (Detached from grid rows to prevent layout/z-index trapping) -->

        <!-- Upgrade Modal Popup -->
        <template x-teleport="body">
            <div x-show="upgradeRequired" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
                style="z-index: 1060; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);">
                <div class="w-100 h-100 d-flex align-items-center justify-content-center position-relative">
                    <!-- Invisible close mask layer -->
                    <div class="position-absolute w-100 h-100" style="z-index: 1; cursor: pointer;"
                        @click="upgradeRequired = false; isLimitedMode = true"></div>
                    <div class="card p-4 text-center mx-auto position-relative"
                        style="z-index: 2; min-width: 380px; max-width: 90vw; background: var(--bg-card); border-color: var(--color-primary);">
                        <i class="bi bi-lock-fill display-4 mb-3" style="color: var(--color-primary);"></i>
                        <h4 class="text-light fw-bold">Advanced Insights Locked</h4>
                        <p class="text-muted mb-4">You have used your free full calculations. Upgrade your account to
                            continue unlocking deep stats, benchmarks, and custom PDF outputs.</p>
                        <div class="d-flex flex-column gap-2 justify-content-center mt-2">
                            <a href="/register" class="btn btn-primary-cta w-100">Upgrade to Pro</a>
                            <button type="button" class="btn text-muted p-2"
                                @click="upgradeRequired = false; isLimitedMode = true"
                                style="font-size: 0.9rem; text-decoration: underline; background: transparent; border: none; cursor: pointer;">Continue
                                with Limited Results</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Guest Email Lead Capture Modal -->
        <template x-teleport="body">
            <div x-show="showEmailModal" x-cloak class="position-fixed top-0 start-0 w-100 h-100"
                style="z-index: 1060; background: rgba(0,0,0,0.85); backdrop-filter: blur(5px);">
                <div class="w-100 h-100 d-flex align-items-center justify-content-center position-relative">
                    <!-- Invisible close mask layer -->
                    <div class="position-absolute w-100 h-100" style="z-index: 1; cursor: pointer;"
                        @click="showEmailModal = false"></div>
                    <div class="card p-4 mx-auto position-relative"
                        style="z-index: 2; min-width: 400px; max-width: 90vw; background: var(--bg-card); border: 1px solid rgba(255,255,255,0.15); box-shadow: 0px 10px 40px rgba(0,0,0,0.5);">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="text-light fw-bold mb-0"><i
                                    class="bi bi-envelope-paper-fill text-primary-accent me-2"></i> Get Your Report</h5>
                            <button type="button" aria-label="Close" @click.stop.prevent="showEmailModal = false"
                                style="background: transparent; border: none; outline: none; cursor: pointer; padding: 5px;">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#a1a1aa"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="18" y1="6" x2="6" y2="18"></line>
                                    <line x1="6" y1="6" x2="18" y2="18"></line>
                                </svg>
                            </button>
                        </div>
                        <p class="text-muted mb-4" style="font-size: 0.95rem;">Enter your email to instantly download your
                            comprehensive engagement report.</p>
                        <form @submit.prevent="executePdfDownload">
                            <div class="mb-3">
                                <input type="email" class="form-control text-white" placeholder="Enter your email address"
                                    x-model="guestEmail"
                                    style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-primary-cta w-100" :disabled="isExporting">
                                <span x-show="!isExporting">Download PDF <i class="bi bi-download ms-2"></i></span>
                                <span x-show="isExporting">Generating...</span>
                            </button>
                            <div x-show="exportError" class="text-danger mt-3 fw-medium text-center"
                                style="font-size: 0.85rem;" x-text="exportError"></div>
                        </form>
                    </div>
                </div>
            </div>
        </template>

    </div>

    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('calculatorForm', () => ({
                    step: 1,

                    // Step 1
                    platform: '',

                    // Step 2
                    followers: '',
                    likes: '',
                    comments: '',
                    shares: '',
                    posts: '',

                    // Step 3
                    saves: '',
                    views: '',
                    reach: '',

                    // Step 4
                    industry: '',
                    splitReels: '',
                    splitImages: '',
                    splitCarousel: '',
                    splitVideo: '',

                    // Competitor Fields
                    compName: '',
                    compFollowers: '',
                    compRate: '',

                    // Result Variables
                    hasFakeEngagement: false, // Set to true when fake engagement is detected by backend
                    fakeMessages: [
                        "Possible fake followers or bot engagement detected.",
                        "Your audience reacts but does not interact.",
                        "You may be attracting passive followers."
                    ], // These will be dynamically populated from the API response

                    hasResults: false,
                    isCalculating: false,
                    isLimitedMode: false,
                    upgradeRequired: false,
                    errorMode: false,
                    errorMsg: '',

                    // PDF Export logic
                    isExporting: false,
                    showEmailModal: false,
                    guestEmail: '',
                    exportError: '',
                    cachedReportJson: '',
                    isAuthenticated: {{ auth()->check() ? 'true' : 'false' }},

                    resultEr: 0,
                    resultScore: '',
                    resultRecommendations: [],
                    hasBenchmark: false,
                    benchmarkMessage: '',
                    benchmarkColor: '#85f43a',
                    hasPostNext: false,
                    postNextArray: [],

                    hasCompetitorData: false,
                    compResultName: 'Competitor',
                    youFollowers: '0',
                    compResultFollowers: '0',
                    followersDiff: '0',
                    youRate: '0.00',
                    compResultRate: '0.00',
                    rateDiff: '0.00',
                    compMessage: 'Competitor has 2x engagement with fewer followers.',

                    // Simulator Inputs
                    simFrequency: 15,
                    simRate: 3.5,

                    // Formula calculation outputs
                    getScoreColorClass(score) {
                        if (score === 'Viral' || score === 'High') return 'text-primary-accent';
                        if (score === 'Average') return 'text-warning';
                        return 'text-danger';
                    },

                    get calculatedEr() {
                        let f = Number(this.followers);
                        if (!f) return 0;
                        let interactions = (Number(this.likes) || 0) + (Number(this.comments) || 0) + (Number(this.shares) || 0);
                        return (interactions / f) * 100;
                    },

                    get simFutureFollowers() {
                        let currentFoll = Number(this.followers) || 1000; // default 1000 to show logic early
                        let rateDecimal = Number(this.simRate) / 100;
                        // Use the example logic from requirements adjusted for 3 month frame
                        let gained = (rateDecimal * Number(this.simFrequency)) * 90;
                        return currentFoll + gained;
                    },

                    get simFutureEngagement() {
                        let currentFoll = Number(this.followers) || 1000;
                        let rateDecimal = Number(this.simRate) / 100;
                        // Extrapolated interactions
                        return currentFoll * rateDecimal * Number(this.simFrequency) * 3;
                    },

                    get totalSplit() {
                        return (Number(this.splitReels) || 0) +
                            (Number(this.splitImages) || 0) +
                            (Number(this.splitCarousel) || 0) +
                            (Number(this.splitVideo) || 0);
                    },

                    canProceed() {
                        if (this.step === 1) {
                            return this.platform !== '';
                        }
                        if (this.step === 2) {
                            return this.followers !== '' && this.likes !== '' && this.comments !== '' && this.shares !== '';
                        }
                        if (this.step === 3) {
                            if (this.platform === 'Instagram' && this.saves === '') return false;
                            if ((this.platform === 'YouTube' || this.platform === 'TikTok') && this.views === '') return false;
                            return true; // reach is optional
                        }
                        return true;
                    },

                    canSubmit() {
                        return this.industry !== '';
                    },

                    async submitCalculate() {
                        this.isCalculating = true;
                        this.errorMode = false;

                        try {
                            const response = await fetch('/calculate', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({
                                    followers: this.followers,
                                    likes: this.likes,
                                    comments: this.comments,
                                    shares: this.shares,
                                    total_posts: this.posts,
                                    platform: this.platform,
                                    saves: this.saves,
                                    views: this.views,
                                    reach: this.reach,
                                    industry_name: this.industry,
                                    split_reels: this.splitReels,
                                    split_images: this.splitImages,
                                    split_carousel: this.splitCarousel,
                                    split_video: this.splitVideo,
                                    competitor_name: this.compName,
                                    competitor_followers: this.compFollowers,
                                    competitor_engagement_rate: this.compRate
                                })
                            });

                            const data = await response.json();

                            if (!response.ok) {
                                if (response.status === 403 && data.error === 'guest_limit_reached') {
                                    this.errorMode = true;
                                    this.errorMsg = data.message || "You have reached your free limit. Please sign up to continue.";
                                } else if (response.status === 422) {
                                    this.errorMode = true;
                                    this.errorMsg = "Check inputs: " + (data.message || "Validation failed.");
                                } else {
                                    this.errorMode = true;
                                    this.errorMsg = data.message || "An unexpected error occurred.";
                                }
                                this.isCalculating = false;
                                return;
                            }

                            this.isLimitedMode = data.is_limited_mode || false;
                            this.upgradeRequired = data.upgrade_required || false;

                            this.resultEr = data.engagement_rate;
                            this.resultScore = data.engagement_score;
                            // Prefer advanced insight improvement tips if available, fall back to basic recommendations
                            this.resultRecommendations = (data.improvement_tips && data.improvement_tips.length)
                                ? data.improvement_tips
                                : data.recommendations;

                            if (data.what_to_post_next && data.what_to_post_next.recommendations && data.what_to_post_next.recommendations.length > 0) {
                                this.hasPostNext = true;
                                this.postNextArray = data.what_to_post_next.recommendations;
                            }

                            if (data.benchmark_comparison && !this.isLimitedMode) {
                                this.hasBenchmark = true;
                                this.benchmarkMessage = data.benchmark_comparison.message;
                                this.benchmarkColor = data.benchmark_comparison.badge_color === 'green' ? '#85f43a' : (data.benchmark_comparison.badge_color === 'orange' ? '#f59e0b' : '#ef4444');
                                this.industryAvgRate = data.benchmark_comparison.benchmark_rate;
                                this.updateBarChart();
                            }

                            this.hasResults = true;
                            this.cachedReportJson = data.report_json;

                            if (data.fake_engagement_flag) {
                                this.hasFakeEngagement = true;
                                this.fakeMessages = data.fake_engagement_messages;
                            }

                            if (data.competitor_comparison && !this.isLimitedMode) {
                                this.hasCompetitorData = true;
                                this.compResultName = data.competitor_comparison.competitor_name;
                                this.youFollowers = data.competitor_comparison.you_followers;
                                this.compResultFollowers = data.competitor_comparison.competitor_followers;
                                this.followersDiff = data.competitor_comparison.followers_difference;
                                this.youRate = data.competitor_comparison.you_engagement_rate;
                                this.compResultRate = data.competitor_comparison.competitor_engagement_rate;
                                this.rateDiff = data.competitor_comparison.er_difference_absolute;
                                this.compMessage = data.competitor_comparison.message;
                            }

                        } catch (e) {
                            console.error("Calculation failed", e);
                        } finally {
                            this.isCalculating = false;
                        }
                    },

                    resetError() {
                        this.errorMode = false;
                        this.errorMsg = '';
                    },

                    startPdfDownload() {
                        this.exportError = '';
                        if (!this.isAuthenticated) {
                            this.showEmailModal = true;
                        } else {
                            this.executePdfDownload();
                        }
                    },

                    async executePdfDownload() {
                        if (!this.isAuthenticated && !this.guestEmail) {
                            this.exportError = 'Email is required';
                            return;
                        }

                        this.isExporting = true;
                        this.exportError = '';

                        try {
                            const response = await fetch('/download-report', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/pdf'
                                },
                                body: JSON.stringify({
                                    report_data: this.cachedReportJson,
                                    email: this.guestEmail
                                })
                            });

                            if (!response.ok) {
                                const err = await response.json();
                                this.exportError = err.message || 'Failed to generate PDF';
                                this.isExporting = false;
                                return;
                            }

                            // Convert stream to blob
                            const blob = await response.blob();
                            const url = window.URL.createObjectURL(blob);
                            const a = document.createElement('a');
                            a.style.display = 'none';
                            a.href = url;
                            // Provide a filename hook matching the backend
                            let dateStr = new Date().toISOString().slice(0, 10);
                            a.download = `engagement-report-${dateStr}.pdf`;
                            document.body.appendChild(a);
                            a.click();
                            window.URL.revokeObjectURL(url);

                            this.showEmailModal = false;

                        } catch (e) {
                            console.error("PDF generation failed:", e);
                            this.exportError = 'An unexpected error occurred.';
                        } finally {
                            this.isExporting = false;
                        }
                    },

                    // Chart Control vars
                    barChart: null,
                    lineChart: null,
                    industryAvgRate: 3.2, // Fallback baseline mock before api connect

                    init() {
                        this.$watch('step', value => {
                            if (value === 4) {
                                this.$nextTick(() => {
                                    this.initCharts();
                                });
                            }
                        });

                        this.$watch('simFrequency', () => this.updateLineChart());
                        this.$watch('simRate', () => this.updateLineChart());
                        this.$watch('followers', () => { this.updateLineChart(); this.updateBarChart(); });
                        this.$watch('likes', () => this.updateBarChart());
                        this.$watch('comments', () => this.updateBarChart());
                        this.$watch('shares', () => this.updateBarChart());
                    },

                    initCharts() {
                        Chart.defaults.color = '#a1a1aa';
                        Chart.defaults.font.family = "'Inter', sans-serif";

                        // Bar Chart
                        const barCtx = document.getElementById('engagementBarChart');
                        if (barCtx && !this.barChart) {
                            this.barChart = new Chart(barCtx, {
                                type: 'bar',
                                data: {
                                    labels: ['You', 'Industry Avg'],
                                    datasets: [{
                                        label: 'Engagement Rate (%)',
                                        data: [this.calculatedEr, this.industryAvgRate],
                                        backgroundColor: ['#85f43a', '#47A805'],
                                        borderRadius: 6
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            grid: { color: 'rgba(255,255,255,0.05)' }
                                        },
                                        x: {
                                            grid: { display: false }
                                        }
                                    }
                                }
                            });
                        } else if (this.barChart) {
                            this.updateBarChart();
                        }

                        // Line Chart
                        const lineCtx = document.getElementById('growthLineChart');
                        if (lineCtx && !this.lineChart) {
                            this.lineChart = new Chart(lineCtx, {
                                type: 'line',
                                data: this.getLineChartData(),
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: { display: false },
                                        tooltip: {
                                            callbacks: {
                                                label: function (context) {
                                                    return context.parsed.y.toLocaleString() + ' Followers';
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: false,
                                            grid: { color: 'rgba(255,255,255,0.05)' }
                                        },
                                        x: {
                                            grid: { color: 'rgba(255,255,255,0.05)' }
                                        }
                                    },
                                    elements: {
                                        line: {
                                            tension: 0.3,
                                            borderColor: '#85f43a',
                                            borderWidth: 3
                                        },
                                        point: {
                                            backgroundColor: '#47A805',
                                            radius: 4,
                                            hoverRadius: 6
                                        }
                                    }
                                }
                            });
                        } else if (this.lineChart) {
                            this.updateLineChart();
                        }
                    },

                    getLineChartData() {
                        let baseFoll = Number(this.followers) || 1000;
                        let rate = Number(this.simRate) / 100;
                        let freq = Number(this.simFrequency);

                        let m1 = baseFoll + (rate * freq * 30);
                        let m2 = baseFoll + (rate * freq * 60);
                        let m3 = baseFoll + (rate * freq * 90);

                        return {
                            labels: ['Current', 'Month 1', 'Month 2', 'Month 3'],
                            datasets: [{
                                label: 'Estimated Followers',
                                data: [baseFoll, m1, m2, m3]
                            }]
                        };
                    },

                    updateLineChart() {
                        if (this.lineChart) {
                            this.lineChart.data = this.getLineChartData();
                            this.lineChart.update();
                        }
                    },

                    updateBarChart() {
                        if (this.barChart) {
                            this.barChart.data.datasets[0].data = [this.calculatedEr, this.industryAvgRate];
                            this.barChart.update();
                        }
                    }
                }))
            })
        </script>
    @endpush
@endsection