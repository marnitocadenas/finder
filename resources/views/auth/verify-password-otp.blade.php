@extends('layouts.app')
@section('title','Verify OTP')
@section('content')
<div class="container py-5"><div class="col-md-6 mx-auto card p-4"><h1 class="h3">Verify OTP</h1><p class="text-muted">Enter the 6-digit code sent to {{ $email }}. The code expires in 10 minutes.</p><form method="POST" action="{{ route('password.otp.verify') }}">@csrf <input class="form-control mb-3" name="otp" inputmode="numeric" maxlength="6" placeholder="6-digit OTP" required><button class="btn btn-primary">Verify OTP</button><a class="btn btn-link" href="{{ route('password.request') }}">Request new code</a></form></div></div>
@endsection
