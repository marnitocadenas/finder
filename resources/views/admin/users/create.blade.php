@extends('layouts.app')
@section('title','Create User')
@section('content')@include('admin.users.form',['action'=>route('admin.users.store'),'method'=>'POST'])@endsection
