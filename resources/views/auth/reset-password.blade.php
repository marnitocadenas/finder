@extends('layouts.app')
@section('title','Reset Password')
@section('content')
<div class="container py-5"><div class="col-md-6 mx-auto card p-4"><h1 class="h3">Choose New Password</h1><p class="text-muted">Resetting password for {{ $email }}.</p><form method="POST" action="{{ route('password.update') }}">@csrf <input class="form-control mb-3" type="password" name="password" placeholder="New password" required><input class="form-control mb-3" type="password" name="password_confirmation" placeholder="Confirm password" required><button class="btn btn-primary">Reset Password</button></form></div></div>
@endsection
