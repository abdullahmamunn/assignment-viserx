@extends('layouts.app')
@section('content')
 <div class="row">
    <div class="col-md-12">
        <form action="{{route('user.route.store')}}">
            @csrf
            <div class="form-group">
              <label for="">Role Name</label>
              <select name="role_id" id="">
                <option value="">Select Role</option>
                @foreach ($roles as $role)
                   <option value="{{ $role->id }}">{{$role->name}}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="">Route permission</label>
              <select class="selectpicker" name="menu_id[]" multiple data-live-search="true">
                @foreach ($routes as $route)
                  <option value="menu_id={{$route->id}}@permitted_route={{$route->route}}">{{$route->name}}</option>
                @endforeach
              </select>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
 </div>
@endsection
