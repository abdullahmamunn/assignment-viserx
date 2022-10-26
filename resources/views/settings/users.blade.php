@extends('layouts.app')
@section('content')
 <div class="row">
    <div class="col-md-12">
        <table class="table">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{ ($user->type == 1 ? 'Admin user' : 'Normal User' ) }}</td>
                    <td>
                        <a href="{{route('assign.role',$user->id)}}" class="btn btn-primary">Assign Role</a>
                    </td>
                  </tr>
                @endforeach
            </tbody>

        </table>
    </div>
 </div>
@endsection
