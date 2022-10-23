@extends('auth.app')
@section('content')
<div class="container">
    
    
        {{-- {{auth()->user()->name}} --}}


    <h1>Dashboard</h1>
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
       {{Session::get('success')}} {{Auth::user()->name}}
      </div>
    @endif
    <b>Welcome, {{Auth::user()->name}}</b>
    <h1>kjjmfgdfg</h1>
</div>
@endsection
