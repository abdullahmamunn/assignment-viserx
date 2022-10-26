@extends('layouts.app')
@section('content')
<div class="container">


        {{auth()->user()->name}}


    <h1>Dashboard</h1>
    @if (Session::has('error'))
        <div class="alert alert-danger" role="alert">
            {{Session::get('error')}}
        </div>
    @endif
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
       {{Session::get('success')}} {{Auth::user()->name}}
      </div>
    @endif
    <b>Welcome, {{Auth::user()->name}}</b>
</div>
@endsection
