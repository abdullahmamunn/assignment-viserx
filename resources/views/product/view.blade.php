@extends('layouts.app')
 @section('content')

  <div class="row">
      <div class="col-md-8">
         <div class="card">
             <div class="card-header">
                 <h2>Product List</h2>
                 <form name="sortProducts" id="sortProducts">
                    <input type="hidden" name="url" id="url" value="{{route('product.filter')}}">
                    <select id="sort" name="sort">
                       <option value="">Select</option>
                       <option value="low_to_high">Price: Low to High</option>
                       <option value="high_to_low">Price: High to Low</option>
                       <option value="asc">Sort: ASC</option>
                       <option value="desc">Sort: DESC</option>
                       <option value="active">Sort: Active</option>
                       <option value="inactive">Sort: Inactive</option>
                    </select>
                 </form>
             </div>
             <div class="card-body">
                 <table class="table table-bordered">
                    <thead class="text-center">
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
         </div>
      </div>
      <div class="col-md-4">
          <div class="card">
              <div class="card-header">
                 <span id="addProduct">Add new</span>
                 <span id="updateProduct">Update Product</span>
              </div>
              <div class="card-body">
                  <div class="form-group">
                      <label for="">Product Name</label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">
                      <span class="text-danger" id="nameError"></span>
                  </div>
                  <div class="form-group">
                      <label for="">Description</label>
                      <input type="text" class="form-control" name="description" id="description" placeholder="Enter description">
                      <span class="text-danger" id="positionError"></span>
                  </div>
                  <div class="form-group">
                      <label for="">Price</label>
                      <input type="number" class="form-control" name="price" id="price" placeholder="Enter price">
                      <span class="text-danger" id="phoneError"></span>
                  </div>
                  <div class="form-group">
                      <label for=""></label>
                      <input type="hidden" id="id">
                      <input type="submit" class="btn btn-primary" name="btn_add" id="addBtn" onclick="createNewTeacher()" value="Add">
                      <input type="submit" class="btn btn-success" name="btn_edit" id="editBtn" onclick="updateProduct()" value="Update">
                  </div>

              </div>
          </div>

      </div>
  </div>

<script>
    $('#addProduct').show();
    $('#updateProduct').hide();
    $('#addBtn').show();
    $('#editBtn').hide();
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
      $('#name').val('');
      $('#description').val('');
      $('#price').val('');
      $('#nameError').text('');
      $('#positionError').text('');
      $('#phoneError').text('');
   }
   function createNewTeacher(){
       let name = $('#name').val();
       let description = $('#description').val();
       let price = $('#price').val();
       $.ajax({
           type: 'POST',
           dataType: 'json',
           url: "{{(route('product.store'))}}",
           data: {name: name, description:description, price:price},
           success: function (data) {
               clearData();
               getAll();
           },
           error: function (error) {
               $('#nameError').text(error.responseJSON.errors.name);
               $('#positionError').text(error.responseJSON.errors.position);
               $('#phoneError').text(error.responseJSON.errors.phone);
           }
       });
   }
   function editData(id) {
            // url = "product";
            // editUrl = url + '/' + id + '/edit';
       $.ajax({
           type: 'GET',
           dataType: 'json',
           url: `{{url('product/${id}/edit')}}`,
           success: function (data) {
               $('#updateProduct').show();
               $('#editBtn').show();
               $('#addProduct').hide();
               $('#addBtn').hide();
               $('#id').val(data.id);
               $('#name').val(data.name);
               $('#description').val(data.description);
               $('#price').val(data.price);
               console.log(data);
           }
       })
   }
   function updateProduct() {
       let id = $('#id').val();
       let name = $('#name').val();
       let description = $('#description').val();
       let price = $('#price').val();
       $.ajax({
           type: 'PUT',
           dataType: 'json',
           url: `{{url('product/${id}')}}`,
           data:{name:name, description:description, price:price},
           success: function (data) {
               $('#updateProduct').hide();
               $('#editBtn').hide();
               $('#addProduct').show();
               $('#addBtn').show();
               clearData();
               getAll();
           },
           error: function (error) {
               $('#nameError').text(error.responseJSON.errors.name);
               $('#positionError').text(error.responseJSON.errors.position);
               $('#phoneError').text(error.responseJSON.errors.phone);
           }
       });
   }
   function deleteData(id) {
    // alert(id);
    $.ajax({
        type: 'DELETE',
        dataType: 'json',
        url: `{{url('product/${id}')}}`,
        success: function(data){
            getAll();
        }
     });
   }

$("#sort").on('change', function(){
    var sort = $(this).val();
    var url = $('#url').val()
        $.ajax({
        url: url,
        method: "post",
        data: {sort:sort},
        success: function(response){
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

    })
});
</script>
@endsection

