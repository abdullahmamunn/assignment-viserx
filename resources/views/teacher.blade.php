<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title></title>
    <style>
        .swal2-cancel{
           margin-right: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="text-center">  </h1>
  <div class="row">
      <div class="col-md-8">
         <div class="card">
             <div class="card-header">
                 <h2>informations</h2>
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
                 <span id="addTeacher">Add new Teacher</span>
                 <span id="updateTeacher">Update Teacher</span>
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
                      <input type="submit" class="btn btn-success" name="btn_edit" id="editBtn" onclick="updateTeacher()" value="Update">
                  </div>

              </div>
          </div>

      </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script src="{{asset('js/sweet-alert.js')}}"></script>

<script>
    $('#addTeacher').show();
    $('#updateTeacher').hide();
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
               const Toast = Swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   timerProgressBar: true,
                   didOpen: (toast) => {
                       toast.addEventListener('mouseenter', Swal.stopTimer)
                       toast.addEventListener('mouseleave', Swal.resumeTimer)
                   }
               });
               Toast.fire({
                   icon: 'success',
                   title: 'Data added successfully!'
               });
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
               $('#updateTeacher').show();
               $('#editBtn').show();
               $('#addTeacher').hide();
               $('#addBtn').hide();
               $('#id').val(data.id);
               $('#name').val(data.name);
               $('#description').val(data.description);
               $('#price').val(data.price);
               console.log(data);
           }
       })
   }
   function updateTeacher() {
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
               $('#updateTeacher').hide();
               $('#editBtn').hide();
               $('#addTeacher').show();
               $('#addBtn').show();
               clearData();
               getAll();
               const Toast = Swal.mixin({
                   toast: true,
                   position: 'top-end',
                   showConfirmButton: false,
                   timer: 3000,
                   timerProgressBar: true,
                   didOpen: (toast) => {
                       toast.addEventListener('mouseenter', Swal.stopTimer)
                       toast.addEventListener('mouseleave', Swal.resumeTimer)
                   }
               });
               Toast.fire({
                   icon: 'success',
                   title: 'Data updated successfully!'
               });
           },
           error: function (error) {
               $('#nameError').text(error.responseJSON.errors.name);
               $('#positionError').text(error.responseJSON.errors.position);
               $('#phoneError').text(error.responseJSON.errors.phone);
           }
       });
   }
   function deleteData(id) {
    alert(id);
    $.ajax({
        type: 'DELETE',
        dataType: 'json',
        url: `{{url('product/${id}')}}`,
        success: function(data){
            getAll();
        }
     });
   }
</script>
</body>
</html>
Footer
© 2022 GitHub, Inc.
Footer navigation
Terms
Privacy
