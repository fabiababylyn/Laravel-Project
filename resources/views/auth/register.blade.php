
@extends('layouts.app')

@section('title', 'Student Registration')

@section('content')

<div class="auth">
    <div class="panel">

        <h1>Student Registration</h1>

        <p class="muted">
            Create an account to view your borrowing information.
        </p>

        <form method="POST" action="{{ route('register.post') }}">
            @csrf

            <label>Full Name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                placeholder="Enter your full name"
                required
            >

            <label>Email</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Enter your email address"
                required
            >

            <label>Student Number (optional)</label>
            <input
                type="text"
                name="student_number"
                value="{{ old('student_number') }}"
                placeholder="Enter your student number"
            >

            <label>Phone (optional)</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="Enter your phone number"
            >

            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Create a password"
                required
            >

            <label>Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirm your password"
                required
            >

            <!-- GOOGLE RECAPTCHA -->
            <div style="margin-top: 22px; margin-bottom: 15px;">

                <label style="margin-bottom: 10px;">
                    Security Verification
                </label>

                <div
                    class="g-recaptcha"
                    data-sitekey="{{ config('services.recaptcha.site_key') }}">
                </div>

                @error('g-recaptcha-response')
                    <p class="errors">{{ $message }}</p>
                @enderror

            </div>

            <!-- REGISTER BUTTON -->
            <div class="actions">
                <button type="submit" class="btn">
                    Create Account
                </button>

                <a href="{{ route('login') }}" class="btn light">
                    Back to Login
                </a>
            </div>

        </form>

    </div>
</div>

<!-- GOOGLE RECAPTCHA SCRIPT -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endsection
