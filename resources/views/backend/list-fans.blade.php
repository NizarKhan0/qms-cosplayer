@extends('layouts.master_backend')

@section('title', 'List Fans')

@section('content')

    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @livewire('backend.fan.index-fans')
@endsection
