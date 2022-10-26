@extends('layouts.app')
@section('content')
<div class="container">

    <h2>Welcome to Dashboard</h2>
    <li class="nav-item">
        <a class="nav-link" href="{{route('insert.data')}}">Click here to insert Product Dataset</a>
    </li>
    <div class="row">
        <div class="col-md-4">
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
        </div>
    </div>


</div>
@endsection
