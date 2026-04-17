@extends('layouts.app')

@section('title', 'Social Media Engagement Calculator - MapsilyTools')

@section('content')
<div class="container" x-data="calculatorForm()">
    <!-- Hero Section -->
    <div class="page-hero">
        <div class="hero-badge"><i class="bi bi-calculator me-2"></i>Free Tool</div>
        <h1 class="display-5 fw-bold mb-3">Social Media <span class="text-primary-accent">Engagement Calculator</span></h1>
        <p class="lead text-muted mx-auto" style="max-width: 650px;">
            Calculate your engagement rate across Instagram, Twitter, TikTok, and LinkedIn in seconds. Track your growth and see how you stack up against the competition.
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
                    <h4 class="mb-0 fs-5"><i class="bi bi-bar-chart-steps me-2 text-primary-accent"></i> Calculator Setup</h4>
                    <span class="badge bg-dark border border-secondary text-light">Step <span x-text="step"></span> of 4</span>
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
                                <input type="number" class="form-control form-control-lg" x-model="followers" placeholder="e.g. 15000">
                            </div>
                            
                            <label class="form-label d-flex justify-content-between align-items-center">
                                Total Interactions
                                <span class="badge bg-secondary text-light fw-normal px-2 py-1" style="font-size:0.75rem;">Last Post</span>
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
                                    <label class="form-label text-muted" style="font-size: 0.85rem">Total Posts (Optional)</label>
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
                                    <label class="form-label">Reach <span class="text-muted fw-normal" style="font-size: 0.8rem;">(Optional)</span></label>
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
                                    <small x-show="totalSplit !== 100 && totalSplit > 0" class="text-warning fw-normal">Total: <span x-text="totalSplit"></span>%</small>
                                </label>
                                <div class="row g-3">
                                    <div class="col-6 col-sm-3">
                                        <label class="form-label text-muted" style="font-size:0.8rem">Reels</label>
                                        <input type="number" class="form-control form-control-sm text-center" x-model.number="splitReels" placeholder="0">
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <label class="form-label text-muted" style="font-size:0.8rem">Images</label>
                                        <input type="number" class="form-control form-control-sm text-center" x-model.number="splitImages" placeholder="0">
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <label class="form-label text-muted" style="font-size:0.8rem">Carousel</label>
                                        <input type="number" class="form-control form-control-sm text-center" x-model.number="splitCarousel" placeholder="0">
                                    </div>
                                    <div class="col-6 col-sm-3">
                                        <label class="form-label text-muted" style="font-size:0.8rem">Video</label>
                                        <input type="number" class="form-control form-control-sm text-center" x-model.number="splitVideo" placeholder="0">
                                    </div>
                                </div>
                            </div>
                            
                            <hr class="border-secondary opacity-25 mt-4 mb-4">
                            <h5 class="mb-3">Competitor Comparison <span class="text-muted fw-normal" style="font-size: 0.9rem;">(Optional)</span></h5>
                            <div class="row g-3 mb-4">
                                <div class="col-sm-4">
                                    <label class="form-label text-muted" style="font-size:0.85rem">Competitor Name</label>
                                    <input type="text" class="form-control" x-model="compName" placeholder="e.g. Brand X">
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label text-muted" style="font-size:0.85rem">Followers</label>
                                    <input type="number" class="form-control" x-model.number="compFollowers" placeholder="0">
                                </div>
                                <div class="col-sm-4">
                                    <label class="form-label text-muted" style="font-size:0.85rem">Engagement Rate (%)</label>
                                    <input type="number" class="form-control" x-model.number="compRate" step="0.01" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <hr class="border-secondary opacity-25 mt-5 mb-4">

                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Show generic left button if not on step 1 -->
                            <button type="button" class="btn text-muted fw-medium px-0" x-show="step > 1" @click="step--">
                                <i class="bi bi-arrow-left me-1"></i> Previous
                            </button>
                            <!-- Spacer when Previous is hidden -->
                            <div x-show="step === 1"></div>

                            <button type="button" class="btn btn-primary-cta px-4" x-show="step < 4" @click="step++" :disabled="!canProceed()">
                                Next <i class="bi bi-arrow-right ms-2"></i>
                            </button>

                            <button type="button" class="btn btn-primary-cta px-4" x-show="step === 4" @click="submitCalculate" :disabled="!canSubmit() || isCalculating">
                                <span x-show="!isCalculating">Calculate Engagement <i class="bi bi-magic ms-2"></i></span>
                                <span x-show="isCalculating">Calculating... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span></span>
                            </button>
                        </div>
                        
                        <!-- Guest Error Limit Reached -->
                        <div x-show="errorMode" x-cloak class="alert alert-danger mt-4 border border-danger d-flex align-items-center" style="background-color: rgba(220, 53, 69, 0.1); color: #ff6b6b;">
                            <i class="bi bi-x-circle-fill fs-4 me-3"></i>
                            <div>
                                <strong>Calculation Blocked!</strong> <span x-text="errorMsg"></span>
                            </div>
                        </div>

                        <!-- Fake Engagement Warning Card -->
                        <!-- Old single fake engagement card removed in favor of Grid layout below -->

                        <!-- Calculation Results Grid -->
                        <div x-show="hasResults && !isCalculating" x-transition.opacity.duration.500ms class="mt-5">
                            <h4 class="mb-4 text-light"><i class="bi bi-stars text-primary-accent me-2"></i> Your Engagement Report</h4>
                            
                            <div class="row g-4">
                                <!-- Engagement Rate Card -->
                                <div class="col-md-6">
                                    <div class="card h-100 mb-0" style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                        <div class="card-body text-center d-flex flex-column justify-content-center py-5">
                                            <h6 class="text-muted fw-normal text-uppercase letter-spacing-1 mb-3"><i class="bi bi-activity text-primary-accent me-2"></i> Engagement Rate</h6>
                                            <h2 class="display-3 fw-bold text-light mb-0" x-text="resultEr + '%'"></h2>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quality Score Card -->
                                <div class="col-md-6">
                                    <div class="card h-100 mb-0" style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                        <div class="card-body text-center d-flex flex-column justify-content-center py-5">
                                            <h6 class="text-muted fw-normal text-uppercase letter-spacing-1 mb-3"><i class="bi bi-award text-primary-accent me-2"></i> Quality Score</h6>
                                            <h2 class="display-5 fw-bold mb-0" :class="getScoreColorClass(resultScore)" x-text="resultScore"></h2>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Industry Benchmark -->
                                <div class="col-md-6" x-show="!isLimitedMode && hasBenchmark">
                                    <div class="card h-100 mb-0" :style="`border-top: 3px solid ${benchmarkColor}; background-color: var(--bg-card); border-left: 1px solid rgba(255,255,255,0.05); border-right: 1px solid rgba(255,255,255,0.05); border-bottom: 1px solid rgba(255,255,255,0.05);`">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-3"><i class="bi bi-bar-chart-fill text-primary-accent me-2"></i> Industry Benchmark</h6>
                                            <h5 class="text-light lh-base mt-2" x-text="benchmarkMessage"></h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Real recommendations / insights -->
                                <div class="col-md-6" x-show="!isLimitedMode">
                                    <div class="card h-100 mb-0" style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                        <div class="card-body">
                                            <h6 class="text-muted mb-3"><i class="bi bi-lightbulb-fill text-primary-accent me-2"></i> Recommendations</h6>
                                            <ul class="text-light mt-2 mb-0 ps-3" style="font-size: 0.95rem; opacity: 0.9;">
                                                <template x-for="rec in resultRecommendations">
                                                    <li class="mb-2" x-text="rec"></li>
                                                </template>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- What to post next -->
                                <div class="col-md-6" x-show="!isLimitedMode && hasPostNext">
                                    <div class="card h-100 mb-0" style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                                        <div class="card-body">
                                            <h6 class="text-muted"><i class="bi bi-collection-play-fill text-primary-accent me-2"></i> What To Post Next</h6>
                                            <div class="mt-3">
                                                <template x-for="item in postNextArray">
                                                    <div class="d-flex align-items-start mb-2">
                                                        <i class="bi bi-check-circle-fill text-primary-accent me-2 mt-1"></i>
                                                        <span class="text-light" style="font-size: 0.95rem; opacity: 0.9;" x-text="item"></span>
                                                    </div>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Fake Engagement Warning -->
                                <div class="col-md-6" x-show="hasFakeEngagement">
                                    <div class="card h-100 mb-0" style="background-color: rgba(220,53,69,0.08); border: 1px solid rgba(220,53,69,0.4);">
                                        <div class="card-body">
                                            <h6 class="text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i> Fake Engagement Warning</h6>
                                            <ul class="text-light mt-3 mb-0 ps-3" style="font-size: 0.95rem; opacity: 0.9;">
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
                        <div x-show="hasResults && hasCompetitorData && !isLimitedMode" x-cloak class="card mt-4" style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                            <div class="card-body">
                                <h5 class="text-light mb-3"><i class="bi bi-people-fill text-primary-accent me-2"></i> Competitor Analysis</h5>
                                
                                <div class="table-responsive mb-3">
                                    <table class="table table-dark table-bordered mb-0" style="background-color: var(--bg-main);">
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
                                                <td :class="followersDiff > 0 ? 'text-success' : 'text-danger'" x-text="(followersDiff > 0 ? '+' : '') + followersDiff"></td>
                                            </tr>
                                            <tr>
                                                <td>Engagement Rate</td>
                                                <td x-text="youRate + '%'"></td>
                                                <td x-text="compResultRate + '%'"></td>
                                                <td :class="rateDiff > 0 ? 'text-success' : 'text-danger'" x-text="(rateDiff > 0 ? '+' : '') + rateDiff + '%'"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="p-3 rounded bg-dark border" style="border-color: var(--color-primary) !important;">
                                    <p class="mb-0 fw-bold text-primary-accent" x-text="compMessage"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Engagement Growth Simulator Card -->
                        <div x-show="hasResults && step === 4" x-transition class="card mt-4" style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                            <div class="card-body">
                                <h5 class="text-light mb-3"><i class="bi bi-graph-up-arrow text-primary-accent me-2"></i> Engagement Growth Simulator</h5>
                                <p class="text-muted" style="font-size: 0.9rem;">Estimate your growth after 3 months by adjusting your target monthly posting frequency and engagement rate.</p>
                                
                                <div class="mb-4 mt-4">
                                    <label class="form-label d-flex justify-content-between text-light">
                                        <span>Posting Frequency (Posts/Month)</span>
                                        <span class="fw-bold text-primary-accent" x-text="simFrequency + ' posts'"></span>
                                    </label>
                                    <input type="range" class="form-range" min="1" max="90" x-model.number="simFrequency">
                                </div>
                                
                                <div class="mb-4">
                                    <label class="form-label d-flex justify-content-between text-light">
                                        <span>Target Engagement Rate (%)</span>
                                        <span class="fw-bold text-primary-accent" x-text="simRate + '%'"></span>
                                    </label>
                                    <input type="range" class="form-range" min="0.1" max="15" step="0.1" x-model.number="simRate">
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="p-3 rounded bg-dark border text-center" style="border-color: rgba(255,255,255,0.1) !important;">
                                            <div class="text-muted mb-1" style="font-size: 0.8rem;">Est. Followers (3 Months)</div>
                                            <h4 class="text-primary-accent fw-bold mb-0" x-text="Math.floor(simFutureFollowers).toLocaleString()"></h4>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 rounded bg-dark border text-center" style="border-color: rgba(255,255,255,0.1) !important;">
                                            <div class="text-muted mb-1" style="font-size: 0.8rem;">Est. Interactions (3 Months)</div>
                                            <h4 class="text-primary-accent fw-bold mb-0" x-text="Math.floor(simFutureEngagement).toLocaleString()"></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Visual Analytics Card -->
                        <div x-show="hasResults && step === 4 && !isLimitedMode" x-transition class="card mt-4" style="background-color: var(--bg-card); border: 1px solid rgba(255,255,255,0.05);">
                            <div class="card-body">
                                <h5 class="text-light mb-4"><i class="bi bi-pie-chart-fill text-primary-accent me-2"></i> Visual Analytics</h5>
                                
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="p-3 rounded bg-dark border" style="border-color: rgba(255,255,255,0.05) !important;">
                                            <h6 class="text-muted text-center mb-3" style="font-size:0.85rem">Engagement vs Industry Average</h6>
                                            <div style="position: relative; height:220px;">
                                                <canvas id="engagementBarChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="p-3 rounded bg-dark border" style="border-color: rgba(255,255,255,0.05) !important;">
                                            <h6 class="text-muted text-center mb-3" style="font-size:0.85rem">Monthly Growth Projection</h6>
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

        <!-- Upgrade Modal Popup -->
        <div x-show="upgradeRequired" x-cloak class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" style="z-index: 1050; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px);">
            <div class="card p-4 text-center mx-auto" style="min-width: 380px; max-width: 90vw; background: var(--bg-card); border-color: var(--color-primary);">
                <i class="bi bi-lock-fill display-4 mb-3" style="color: var(--color-primary);"></i>
                <h4 class="text-light fw-bold">Advanced Insights Locked</h4>
                <p class="text-muted mb-4">You have used your free full calculations. Upgrade your account to continue unlocking deep stats, benchmarks, and custom PDF outputs.</p>
                <div class="d-flex flex-column gap-2 justify-content-center mt-2">
                    <a href="/register" class="btn btn-primary-cta w-100">Upgrade to Pro</a>
                    <button type="button" class="btn text-muted p-2" @click="upgradeRequired = false; isLimitedMode = true" style="font-size: 0.9rem; text-decoration: underline;">Continue with Limited Results</button>
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
                <div class="position-absolute top-0 end-0 bg-primary text-dark px-3 py-1 fw-bold" style="border-bottom-left-radius: 12px; font-size: 0.8rem; background-color: var(--color-primary) !important;">PRO</div>
                <div class="card-body p-4">
                    <div class="mb-3 mt-2">
                        <i class="bi bi-rocket-takeoff text-primary-accent" style="font-size: 2.5rem;"></i>
                    </div>
                    <h4 class="fw-bold mb-3 fs-5">Upgrade to Pro</h4>
                    <p class="text-muted mb-4" style="font-size: 0.9rem;">
                        Unlock bulk analysis, competitor benchmarking, historical tracking, and export your reports.
                    </p>
                    <ul class="list-unstyled text-start text-muted mb-4" style="font-size: 0.9rem;">
                        <li class="mb-2"><i class="bi bi-check2-circle text-primary-accent me-2 fs-5 align-middle"></i> Connect accounts directly</li>
                        <li class="mb-2"><i class="bi bi-check2-circle text-primary-accent me-2 fs-5 align-middle"></i> PDF / CSV Exporting</li>
                        <li class="mb-2"><i class="bi bi-check2-circle text-primary-accent me-2 fs-5 align-middle"></i> White-label reports</li>
                    </ul>
                    <a href="#" class="btn btn-primary-cta w-100">Get Pro for $9/mo</a>
                </div>
            </div>

        </div>

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
                            industry_id: 1, // Fallback for UI testing
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
                    
                    if (response.status === 403 && data.error === 'guest_limit_reached') {
                        this.errorMode = true;
                        this.errorMsg = data.message;
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
                                        label: function(context) {
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
