@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="mb-4">Global Tool Settings</h2>
            
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h5>Aesthetics & Copy</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 p-3 bg-light rounded border border-warning">
                            <div class="form-check form-switch fs-5 mb-2">
                                <input class="form-check-input" type="checkbox" role="switch" name="white_label_active" value="1" {{ ($settings['white_label_active'] ?? '0') == '1' ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold">Enable White Label Experience</label>
                            </div>
                            <p class="text-muted small mb-3">Turning this on removes Mapsily branding and replaces it with your custom SaaS branding below across the App UI and PDF exports.</p>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Client Tool Title</label>
                                    <input type="text" name="custom_client_title" class="form-control" value="{{ $settings['custom_client_title'] ?? 'Social Media Engagement Calculator' }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Custom Top Logo (PNG/JPG)</label>
                                    <input type="file" name="custom_logo" class="form-control" accept="image/*">
                                    @if(!empty($settings['custom_logo_path']))
                                        <div class="mt-2 text-success small"><i class="bi bi-check-circle"></i> Custom logo active.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tool Title</label>
                            <input type="text" name="tool_title" class="form-control" value="{{ $settings['tool_title'] ?? '' }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Primary Call To Action (Button)</label>
                            <input type="text" name="cta_text" class="form-control" value="{{ $settings['cta_text'] ?? '' }}">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Primary Brand Color</label>
                                <input type="color" name="primary_color" class="form-control form-control-color" value="{{ $settings['primary_color'] ?? '#85f43a' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Dark Mode Background</label>
                                <input type="color" name="dark_mode_bg" class="form-control form-control-color" value="{{ $settings['dark_mode_bg'] ?? '#272727' }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h5>Usage Limits & Calculations</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Anonymous Guest Limit</label>
                                <input type="number" name="guest_limit" class="form-control" value="{{ $settings['guest_limit'] ?? 2 }}">
                                <div class="form-text">Max calculations before forced sign up.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Standard Authenticated Limit</label>
                                <input type="number" name="auth_limit" class="form-control" value="{{ $settings['auth_limit'] ?? 3 }}">
                                <div class="form-text">Max calculations before forced Premium CTA.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white border-0 pt-3 pb-0">
                        <h5>Algorithm Thresholds</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Viral Engagement Threshold (%)</label>
                                <input type="number" step="0.1" name="er_viral" class="form-control" value="{{ $settings['er_viral'] ?? 6 }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">High Engagement Threshold (%)</label>
                                <input type="number" step="0.1" name="er_high" class="form-control" value="{{ $settings['er_high'] ?? 3 }}">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary px-4 mt-3">Apply Changes Globally</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
