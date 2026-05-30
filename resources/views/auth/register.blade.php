@extends('layouts.app')
@section('title','Register')
@section('content')
<section class="auth-screen">
    <div class="auth-shell">
        <aside class="auth-brand-panel">
            <a href="{{ route('home') }}" class="auth-brand">
                <img src="{{ asset('images/tmc-logo.png') }}" alt="Trinidad Municipal College logo">
                <span>
                    <strong>TMC</strong>
                    <small>Lost and Found</small>
                </span>
            </a>
            <div>
                <div class="module-eyebrow">Student Access</div>
                <h1>Create Account</h1>
                <p>Register once to submit lost reports, browse found items, and manage your claims online.</p>
            </div>
            <div class="auth-feature-list">
                <span><i class="fa-solid fa-user-graduate"></i> Student workspace</span>
                <span><i class="fa-solid fa-file-signature"></i> Claim tracking</span>
                <span><i class="fa-solid fa-bell"></i> Notifications</span>
            </div>
        </aside>

        <div class="auth-card auth-card-wide">
            <div class="auth-card-header">
                <span><i class="fa-solid fa-user-plus"></i></span>
                <div>
                    <h2>Student Registration</h2>
                    <p>Use your active email and a strong password.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="auth-form">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label" for="register-name">Full Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                            <input id="register-name" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full name" required autofocus>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="register-student-id">Student ID</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-id-card"></i></span>
                            <input id="register-student-id" class="form-control" name="student_id" value="{{ old('student_id') }}" placeholder="Student ID">
                        </div>
                    </div>

                    <div class="col-12">
                        <label class="form-label" for="register-email">Email Address</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                            <input id="register-email" class="form-control" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="register-password">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input id="register-password" class="form-control" name="password" type="password" placeholder="Minimum 8 characters" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label" for="register-password-confirmation">Confirm Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input id="register-password-confirmation" class="form-control" name="password_confirmation" type="password" placeholder="Repeat password" required>
                        </div>
                    </div>
                </div>

                <div class="auth-password-note">
                    <i class="fa-solid fa-circle-info"></i>
                    <span>Password must be at least 8 characters and include an uppercase letter and a number.</span>
                </div>

                <button class="btn btn-warning w-100">
                    <i class="fa-solid fa-user-plus me-2"></i>Create Account
                </button>

                <div class="auth-switch">
                    <span>Already registered?</span>
                    <a href="{{ route('login') }}">Back to login</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
