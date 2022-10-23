@extends('auth.app')
@section('content')
<main class="signup-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if (Session::has('fail'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('fail')}}
                      </div>
                    @endif
                    <h3 class="card-header text-center">Product List</h3>
                    {{-- <a href="{{route('product.create')}}">Add new</a> --}}
                    <a type="button" class="btn btn-primary btn-right float-right" data-toggle="modal" data-target="#addNew">Add New</a>

                    <div class="card-body">
                      <table class="table table-striped table-hover">
                       <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                       </thead>
                       <tbody>

                       </tbody>
                      </table>
                    </div>

                    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add New Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="simpleinput">Name</label>
                                        <input type="text" name="name" id=""
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="simpleinput">Price</label>
                                        <input type="number" name="price" id=""
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="simpleinput">Description</label>
                                        <textarea type="text" name="description" id=""
                                        class="form-control"></textarea>
                                    </div>
                                </div>
                             </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" id="addProduct">Save changes</button>
                            </div>
                        </div>
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

        function getAll(){
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: "{{route('product.index')}}",
            success:function (response) {
                console.log(response);
                var data = '';
                $.each(response,function (key, value) {
                    data = data + "<tr>"
                        data = data + "<td>"+ (key+=1) +"</td>"
                        data = data + "<td>"+ value.name +"</td>"
                        data = data + "<td>"+ value.description +"</td>"
                        data = data + "<td>"+ value.price +"</td>"
                        data = data + "<td style='width: 120px'>"
                        data = data + " <a href=\"javascript:void(0)\" class=\"btn btn-primary mr-2\" onclick=\"editData("+value.id+")\"><i class=\"fas fa-edit\"></i></a>"
                        data = data + "<a href=\"javascript:void(0)\" class=\"btn btn-danger\" onclick=\"deleteData("+value.id+")\"><i class=\"fas fa-trash\"></i></a>"
                        data = data + "</td>"
                    data = data + "</tr>"
                });
             $('tbody').html(data);
            }
        });
    }
    getAll();

    function clearData() {
        $('input[name="name"]').val('');
        $('textarea[name="description"]').val('');
        $('input[name="price"]').val('');
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
                    getAll();
                },
            });
        });
    });
</script>
