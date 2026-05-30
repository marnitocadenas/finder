@extends('layouts.app')
@section('title','Edit Category')
@section('content')@include('admin.categories.form',['action'=>route('admin.categories.update',$category),'method'=>'PUT'])@endsection
