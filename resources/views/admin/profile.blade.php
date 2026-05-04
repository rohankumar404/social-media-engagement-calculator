@extends('admin.layout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white p-4 border-0 d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-person-badge text-primary fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Profile Settings</h4>
                        <p class="text-white-50 mb-0 small">Manage your administrative account credentials</p>
                    </div>
                </div>
                
                <div class="card-body p-5 bg-white">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        
                        <!-- Account Info Section -->
                        <div class="section-header mb-4">
                            <h5 class="fw-bold text-dark border-start border-4 border-primary ps-3">Account Identity</h5>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label class="form-label fw-semibold text-muted small text-uppercase">Current Login ID</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-envelope-fill text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0" value="{{ $admin->email }}" readonly disabled>
                                </div>
                                <div class="form-text">Your active identification for system access.</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold text-muted small text-uppercase">New Login ID (Email)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-envelope-plus text-primary"></i></span>
                                    <input type="email" name="email" id="email" class="form-control border-start-0 @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Security Section -->
                        <div class="section-header mb-4 mt-5">
                            <h5 class="fw-bold text-dark border-start border-4 border-danger ps-3">Security & Password</h5>
                        </div>

                        <div class="mb-4">
                            <label for="current_password" class="form-label fw-semibold text-muted small text-uppercase">Verify Current Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="bi bi-shield-lock text-danger"></i></span>
                                <input type="password" name="current_password" id="current_password" class="form-control border-start-0 @error('current_password') is-invalid @enderror" placeholder="Enter password to confirm changes" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <label for="new_password" class="form-label fw-semibold text-muted small text-uppercase">New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-key text-success"></i></span>
                                    <input type="password" name="new_password" id="new_password" class="form-control border-start-0 @error('new_password') is-invalid @enderror" placeholder="Minimum 8 characters">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-text">Leave empty if you don't want to change it.</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label fw-semibold text-muted small text-uppercase">Confirm New Password</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-key-fill text-success"></i></span>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control border-start-0" placeholder="Repeat new password">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5 pt-3 border-top">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card { transition: transform 0.2s; }
    .input-group-text { border-color: #dee2e6; color: #6c757d; }
    .form-control:focus { box-shadow: none; border-color: #85f43a; }
    .btn-primary { background-color: #272727; border-color: #272727; }
    .btn-primary:hover { background-color: #000; border-color: #000; }
    .border-primary { border-color: #85f43a !important; }
</style>
@endsection
