@extends('auth.app')
@section('content')
<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    @if (Session::has('fail'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('fail')}}
                      </div>
                    @endif
                    <h3 class="card-header text-center">Product Add</h3>
                    <div class="card-body">
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Product Name" id="name" class="form-control" name="name" value="{{old('name')}}">
                                @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <textarea name="description" class="form-control" id="" cols="5" rows="5" placeholder="Product Description"></textarea>
                                @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="number" placeholder="price" id="" class="form-control"
                                    name="price">
                                @if ($errors->has('price'))
                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mx-auto">
                                <input type="submit" class="btn btn-primary" id="addProduct">
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    function clearData() {
        $('input[name="name"]').val('');
        $('textarea[name="description"]').val('');
        $('input[name="price"]').val('');

        // $('#nameError').text('');
        // $('#positionError').text('');
        // $('#phoneError').text('');
    }

        $(document).on('click','#addProduct',function(e){
            let name =  $('input[name="name"]').val();
            let description =  $('textarea[name="description"]').val();
            let price =  $('input[name="price"]').val();

            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: "{{route('product.store')}}",
                data: {name: name, description:description, price:price},
                success: function (data) {
                    console.log(data);
                    clearData();
                },
            });
        });
    });
</script>
