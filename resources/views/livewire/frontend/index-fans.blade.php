@extends('layouts.master_frontend')

@section('title', $cosplayerName)

@section('content')

    @livewire('frontend.getqueue', ['cosplayerId' => $cosplayerId])
    {{-- @livewire('fans.create-fans') --}}
@endsection
