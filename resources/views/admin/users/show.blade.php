@extends('layouts.app')
@section('title','User Details')
@section('content')<div class="card p-4"><h1 class="h3">{{ $user->name }}</h1><p>{{ $user->email }}</p><span class="badge bg-primary">{{ $user->role }}</span></div>@endsection
