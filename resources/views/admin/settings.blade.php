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

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Global Default Currency</label>
                                <select name="system_default_currency" class="form-select">
                                    @foreach($currencies as $curr)
                                        <option value="{{ $curr->code }}" {{ ($settings['system_default_currency'] ?? 'USD') == $curr->code ? 'selected' : '' }}>
                                            {{ $curr->code }} ({{ $curr->symbol }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <hr class="my-4">
                        <h5>Support & Notifications</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Support Email (Shown in Footer)</label>
                                <input type="email" name="support_email" class="form-control" value="{{ $settings['support_email'] ?? 'support@mapsily.com' }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Lead Notification Emails</label>
                                <input type="text" name="lead_notification_emails" class="form-control" value="{{ $settings['lead_notification_emails'] ?? 'work.fuelcab@gmail.com' }}">
                                <div class="form-text">Comma separated list of emails to receive lead alerts.</div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary px-4 mt-3">Apply Changes Globally</button>
                    </div>
                </div>
            </form>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                    <h5>Currency Management Table</h5>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCurrencyModal">
                        <i class="bi bi-plus-lg"></i> Add New Currency
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ISO Code</th>
                                    <th>Symbol</th>
                                    <th>Exchange Rate (vs USD)</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($currencies as $curr)
                                    <tr>
                                        <td><strong>{{ $curr->code }}</strong></td>
                                        <td>{{ $curr->symbol }}</td>
                                        <td>1 USD = {{ number_format($curr->exchange_rate, 4) }} {{ $curr->code }}</td>
                                        <td>
                                            @if(($settings['system_default_currency'] ?? 'USD') != $curr->code)
                                                <form action="{{ route('admin.currencies.delete', $curr->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this currency?')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="badge bg-secondary">System Default</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Currency Modal -->
<div class="modal fade" id="addCurrencyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('admin.currencies.add') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Currency</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">ISO Code (e.g. EUR)</label>
                        <input type="text" name="code" class="form-control" required maxlength="3" placeholder="EUR">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Symbol (e.g. €)</label>
                        <input type="text" name="symbol" class="form-control" required placeholder="€">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Exchange Rate (Relative to 1 USD)</label>
                        <input type="number" step="0.0001" name="exchange_rate" class="form-control" required placeholder="0.93">
                        <div class="form-text">Example: If 1 USD = 0.93 EUR, enter 0.93</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Currency</button>
                </div>
            </div>
        </form>
    </div>
</div>
        </div>
    </div>
</div>
@endsection
