@extends('layouts.app')
@section('title','Create Category')
@section('content')@include('admin.categories.form',['action'=>route('admin.categories.store'),'method'=>'POST'])@endsection
