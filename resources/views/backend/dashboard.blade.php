@extends('layouts.master_backend')

@section('title', 'Dashboard')

@section('content')


<div class="section">
    <!--card stats start-->
    <div id="card-stats" class="pt-0">
        @livewire('dashboardqueuestats') <!-- Include the Livewire component here -->
    </div>
    <!--card stats end-->
 </div>

@endsection
