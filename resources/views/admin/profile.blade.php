@extends('admin.layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Admin Profile Settings</h5>
                    <i class="bi bi-person-badge-fill text-primary fs-4"></i>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label class="form-label fw-bold">Current ID (Email)</label>
                            <input type="email" class="form-control bg-light" value="{{ $admin->email }}" readonly disabled>
                            <small class="text-muted">This is your current login identifier.</small>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">New ID (Email)</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Current Password</label>
                            <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                            <small class="text-muted">Required to authorize changes.</small>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="new_password" class="form-label fw-bold">New Password</label>
                                <input type="password" name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror">
                                <small class="text-muted">Leave blank to keep current password.</small>
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="new_password_confirmation" class="form-label fw-bold">Confirm New Password</label>
                                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-2"></i> Update Profile Credentials
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
