@extends('layouts.app')
@section('content')
 <div class="row">
    <div class="col-md-12">
        <form action="{{route('user.role.store')}}">
            @csrf
            <div class="form-group">
              <label for="">User Name</label>
              <select name="user_id" id="">
                <option value="{{ $user->id }}">{{$user->name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label for="">Role</label>
              <select name="role_id" id="">
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                  <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
 </div>
@endsection
