@extends('app.app')
@section('content')
     <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-8 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <h1>List Ordering</h1>
                            </div>
                        </div>
                    </div><!-- /# column -->
                    <div class="col-lg-4 p-0">
                        <div class="page-header">
                            <div class="page-title">
                                <ol class="breadcrumb text-right">
                                    <li><a href="#">Ordering</a></li>
                                    <li class="active">List</li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- /# column -->
                </div><!-- /# row -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                                <div class="order-list-item">
                                    <table class="table" id="listOrder">
                                        <thead>
                                        <tr>
                                            <th>Customer</th>
                                            <th>Order ID</th>
                                            <th>Date</th>
                                            <th>Menu Product</th>
                                            <th>Grand Total</th>
                                            <th>Service</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                        </thead>
                                        <tbody  id="tbody">
                                            <tr>
                                                <td colspan="7">Loading data .....</td>    
                                                <td></td>     
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
							</div>
						</div>
					</div>
                </div>
            </div>
  
<div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <span class="badge badge-info" id="badge_status"></span>
        </div>
        <form action="{{Route('order.update')}}" method="POST">
            {{ csrf_field() }}
            <div class="modal-body">
                <table class="table">
                    <tbody>
                        <input type="hidden" id="id" name="id">
                        
                        <tr>
                            <td>Change Status*</td>
                            <td>
                                <select name="status" id="status" required class="form-control">
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>No. Resi / Kurir</td>
                            <td>
                                <input type="text" class="form-control">
                            </td>
                        </tr>
                        <tr class="delivery">
                            <td>Shipping</td>
                            <td><span id="txtShipping"></span></td>
                        </tr>
                        <tr>
                            <td>Alamat / Meja </td>
                            <td>
                                <input type="text" readonly class="form-control" id="addr_meja">
                            </td>
                        </tr>
                    </tbody>
                </table>
            
                <table class="table table-responsive table-bordered">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Name</td>
                            <td>Variant</td>
                            <td>QTY</td>
                            <td>Note</td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                <button type="submit" id="btnSave" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        </div>
    </div>
    </div>

@endsection
@section('script')
    <script>
        function updateOrder(id){
            $("#modalUpdate").modal('show',{backdrop: 'true'});
            $("#exampleModalLabel").html(id);
            $.get(
            "{{ route('api.sale.detail') }}",
                {
                    id: id,
                },
                function(data) {
                    console.log(data.data);
                    $("#exampleModalLabel").html(data.data['number']);
                    $("#id").val(id);
                    let addr = data.data['address'];
                    let seat = data.data['seat'];
                    let service = data.data['service'];
                    let status = data.data['status'];
                    var bad_status = ""
                    if(status==1){
                        bad_status = "Waiting Payment";
                    }else if(status==2){
                        bad_status = "Prepare Order";
                    }else if(status==3){
                        if(service=="delivery"){
                            bad_status = "Delivery";
                        }else{
                            bad_status = "Ready To Pick";
                        }
                    }else if(status==4){
                        bad_status = "Order Accepted";
                    }else if(status==5){
                        bad_status = "Canceled";
                    }
                    $("#badge_status").html(bad_status);
                    var detail = "";
                    if(service == "delivery"){
                        detail = addr;
                        $("#txtShipping").html(data.data['shipping_method']);
                        $(".delivery").show();
                    }else{
                        detail = seat;
                        $(".delivery").hide();
                    }
                    $("#addr_meja").val(detail);
                    if(status==1 || status == 4 || status == 5){
                        $("#btnSave").attr("disabled",true);
                    }

                    if(status==2){
                        $isi = '<option value=""></option>';
                        $isi +='<option value="3">Delivery / Ready To Pick</option>'+
                                '<option value="4">Order Accepted</option>'+
                                '<option value="5">Cancel</option>';
                    }else if(status==3){
                        $isi = '<option value=""></option>';
                        $isi +='<option value="4">Order Accepted</option>'+
                                '<option value="5">Cancel</option>';
                    }
                    $("#status").html($isi);

                    // $.each(data.detail, function(index, value) {

                    //     // string = string + `<option value="` + index + `">` + value + `</option>`;
                    // })
                }
            );
        }
       
        	//DATABASE REALTIME
			// Get Data Order store
            var storeId = <?php echo Auth()->user()->store_id ?> ;
			firebase.database().ref('orders/store-'+storeId).on('value', function(snapshot) {
                var value = snapshot.val();
                var htmls = [];
                $.each(value, function(index, value){
                if(value) {
                    var status = value.status;
                    if (status=="Wait Payment") {
                        status = '<span  class="btn btn-rounded btn-danger">Wait Payment</span>';
                    }else if (status=="Prepare Order") {
                        status = '<span  class="btn btn-rounded btn-warning">Prepare Order	</span>';
                    }else if (status=="Delivery") {
                        status = '<span  class="btn btn-rounded btn-info">Delivery</span>';
                    }else if (status=="Ready To Pick") {
                        status = '<span  class="btn btn-rounded btn-info">Delivery</span>';
                    }else if (status=="Order Accepted") {
                        status = '<span  class="btn btn-rounded btn-success">Order Accepted</span>';
                    }else if (status=="Canceled") {
                        status = '<span  class="btn btn-rounded btn-danger">Wait Payment</span>';
                    }
                    else{
                        status = '<span  class="btn btn-rounded btn-default">'+value.status+'</span>';
                    }
                htmls.push('<tr>\
                <td>'+ value.customer_name +'</td>\
                <td>'+ value.number +'</td>\
                <td>'+ value.date +'</td>\
                <td>'+ value.menu_name +'</td>\
                <td align="right"><strong>Rp. '+ value.grand_total +'</strong></td>\
                <td>'+ value.service +'</td>\
                <td>'+ status +'</td>\
                <td>\
                    <a href="/order/detail/'+value.id+'" class="btn btn-info" data-id="'+value.id+'"><i class="glyphicon glyphicon-eye-open"></i> View</a>\
                    <a href="javascript:void(0)" onclick="updateOrder('+value.id+')" class="btn btn-primary updateData" data-id="'+value.id+'"><i class="glyphicon glyphicon-edit"></i> Update</a>\
                </td>\
                </tr>');
                }    	
                lastIndex = index;
                });
                $('#tbody').html(htmls);
                $("#submitUser").removeClass('desabled');
			});
			
			
			// Add Data
			// $('#submitUser').on('click', function(){
            //     var values = $("#addUser").serializeArray();
            //     var first_name = values[0].value;
            //     var last_name = values[1].value;
            //     var userID = lastIndex+1;
                
            //     firebase.database().ref('users/' + userID).set({
            //     first_name: first_name,
            //     last_name: last_name,
            //     });
                
            //     // Reassign lastID value
            //     lastIndex = userID;
            //     $("#addUser input").val("");
			// });
			
			// Update Data
			// var updateID = 0;
			// $('body').on('click', '.updateData', function() {
            //     updateID = $(this).attr('data-id');
            //     firebase.database().ref('users/' + updateID).on('value', function(snapshot) {
            //         var values = snapshot.val();
            //         var updateData = '<div class="form-group">\
            //         <label for="first_name" class="col-md-12 col-form-label">First Name</label>\
            //         <div class="col-md-12">\
            //         <input id="first_name" type="text" class="form-control" name="first_name" value="'+values.first_name+'" required autofocus>\
            //         </div>\
            //         </div>\
            //         <div class="form-group">\
            //         <label for="last_name" class="col-md-12 col-form-label">Last Name</label>\
            //         <div class="col-md-12">\
            //         <input id="last_name" type="text" class="form-control" name="last_name" value="'+values.last_name+'" required autofocus>\
            //         </div>\
            //         </div>';
                    
            //         $('#updateBody').html(updateData);
            //     });
			// });
			
			// $('.updateUserRecord').on('click', function() {
            //     var values = $(".users-update-record-model").serializeArray();
            //     var postData = {
            //         first_name : values[0].value,
            //         last_name : values[1].value,
            //     };
                
            //     var updates = {};
            //     updates['/users/' + updateID] = postData;
                
            //     firebase.database().ref().update(updates);
                
            //     $("#update-modal").modal('hide');
			// });
			
			
			// Remove Data
			// $("body").on('click', '.removeData', function() {
            //     var id = $(this).attr('data-id');
            //     $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="'+ id +'">');
            // });
                
            // $('.deleteMatchRecord').on('click', function(){
            //     var values = $(".users-remove-record-model").serializeArray();
            //     var id = values[0].value;
            //     firebase.database().ref('users/' + id).remove();
            //     $('body').find('.users-remove-record-model').find( "input" ).remove();
            //     $("#remove-modal").modal('hide');
            // });
            // $('.remove-data-from-delete-form').click(function() {
            //     $('body').find('.users-remove-record-model').find( "input" ).remove();
			// });
	

    </script>
@endsection
