@extends('layouts.master_frontend')

@section('title', 'Queue')

@section('content')

    @livewire('fans.create-fans', ['cosplayerId' => $cosplayerId])
    {{-- @livewire('fans.create-fans') --}}
@endsection
