@extends('layouts.app')
@section('title','Edit User')
@section('content')@include('admin.users.form',['action'=>route('admin.users.update',$user),'method'=>'PUT'])@endsection
