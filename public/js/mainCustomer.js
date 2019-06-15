$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
   
	$('#customers-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getCustomers',
        columns:[
            { data: 'name', name: 'name' },
            { data: 'thumbnail', name: 'thumbnail' },
            { data: 'mobile', name: 'mobile' },
            { data: 'address', name: 'address' },
            { data: 'action', name: 'action' }
            ]
	});
    $('.btn-add').on('click',function(e){
       
        $('#modal-add').modal('show')

        $('#span_thumbnail_add').html('');
        $('#span_name_add').html('');
        $('#span_email_add').html('');
        $('#span_password_add').html('');
        $('#span_address_add').html('');
        $('#span_birthday_add').html('');
        $('#span_mobile_add').html('');

    })
    $('#form-add').submit(function(e){
        e.preventDefault();
        // var formData = $('#form-add').serialize();
        var data = new FormData();
        data.append('_token',$('meta[name="csrf-token"]').attr('content'));
        data.append('thumbnail',$('#thumbnail_add')[0].files[0] );
        data.append('name',$('#name_add').val());
        data.append('email',$('#email_add').val());
        data.append('password',$('#password_add').val());
        data.append('address',$('#address_add').val());
        data.append('birthday',$('#birthday_add').val());
        data.append('mobile',$('#mobile_add').val());
        $('#span_thumbnail_add').html('');
        $('#span_name_add').html('');
        $('#span_email_add').html('');
        $('#span_password_add').html('');
        $('#span_address_add').html('');
        $('#span_birthday_add').html('');
        $('#span_mobile_add').html('');
        // 
        $.ajax({
            type:'post',
            url:'/admin/customers',
            data: data,
            contentType: false,
            processData:false,
            success : function(reponse){
                // window.location.reload();
                toastr.success('Add success!');
                $('#modal-add').modal('hide')
                $('#customers-table').DataTable().ajax.reload();


                $('.img-thumbnail').attr('src','http://ssl.gstatic.com/accounts/ui/avatar_2x.png');
                $('#name_add').val('');
                $('#birthday_add').val('');
                $('#address_add').val('');
                $('#mobile_add').val('');
                $('#email_add').val('');
                $('#password_add').val('');
                $('#thumbnail_add').val('');
            },
            error: function(jq, status , throwE){
                console.log(jq)

                jQuery.each(jq.responseJSON.errors,function(key,value){
                    $('#span_'+key+'_add').html('<p style ="color:red;">'+value+'</p>');
                    toastr.error(value);
                })  
            }
        
        })
    })/////////////////////////////

    //Show
    $(document).on('click','.btn-show',function(){
        
        $('#modal-show').modal('show');
        var id = $(this).data('id');
        $.ajax({
            type:'get',
            url:'/admin/customers/'+id,
            success: function(reponse){
                $('#customer_id').html(reponse.id);
                $('#customer_name').html(reponse.name);
                $('#customer_email').html(reponse.email);
                if(reponse.thumbnail!=null){
                    $('#thumbnail_show').attr("src","/storage/"+reponse.thumbnail+"");
                }
                else{
                    $('#thumbnail_show').attr("src","http://ssl.gstatic.com/accounts/ui/avatar_2x.png");
                }
                $('#customer_mobile').html(reponse.mobile);
                $('#customer_address').html(reponse.address);
                $('#customer_birthday').html(reponse.birthday);
                $('#customer_level').html(reponse.level_id);
                
                
            }

        })
    })

    $(document).on('click','.btn-edit',function(){
        $('#modal-update').modal('show');
         $('#span_thumbnail_update').html('');
        $('#span_name_update').html('');
        $('#span_email_update').html('');
        $('#span_password_update').html('');
        $('#span_birthday_update').html('');
        $('#span_mobile_update').html('');
        $('#span_address_update').html('');

        
        var id = $(this).data('id');
        $.ajax({
            type:'get',
            url:'/admin/customers/'+id+'/edit',
            success:function(reponse){
                $('#customer_id_update').val(reponse.id);
                $('#customer_name_update').val(reponse.name);
                $('#customer_email_update').val(reponse.email);
                $('#customer_mobile_update').val(reponse.mobile);
                $('#customer_birthday_update').val(reponse.birthday);
                $('#customer_address_update').val(reponse.address);
                if(reponse.thumbnail==null){
                    $('#img_thumbnail_update').attr("src","http://ssl.gstatic.com/accounts/ui/avatar_2x.png");
                    
                }
                else{
                    $('#img_thumbnail_update').attr("src","/storage/"+reponse.thumbnail+"");
                }
            }
        })
    })

    $('#form-update').submit(function(e){
        e.preventDefault();
        
        var id = $('#customer_id_update').val();
        var data = new FormData();
        data.append('_token',$('meta[name="csrf-token"]').attr('content'));
        data.append('thumbnail',$('#customer_thumbnail_update')[0].files[0]);
        data.append('name',$('#customer_name_update').val());
        data.append('_method',$('#put_update').val());
        data.append('id',id);
        data.append('email',$('#customer_email_update').val());
        data.append('password',$('#customer_password_update').val()); 
        data.append('address',$('#customer_address_update').val()); 
        data.append('mobile',$('#customer_mobile_update').val()); 
        data.append('birthday',$('#customer_birthday_update').val()); 
        $('#span_thumbnail_update').html('');
        $('#span_name_update').html('');
        $('#span_email_update').html('');
        $('#span_password_update').html('');
        $('#span_birthday_update').html('');
        $('#span_mobile_update').html('');
        $('#span_address_update').html('');
        $.ajax({
            type:'post',
            url:'/admin/customers/'+id,
            data:data,
            contentType:false,
            processData:false,
            success:function(reponse){
                toastr.success('Update success!');
                $('#modal-update').modal('hide');
               $('#customers-table').DataTable().ajax.reload();
            },
            error: function(jq, status , throwE){
                console.log(jq)
                jQuery.each(jq.responseJSON.errors,function(key,value){
                    $('#span_'+key+'_update').html('<p style ="color:red;">'+value+'</p>');
                    toastr.error(value);
                })  
            }
        })
        
    })

    $(document).on('click','.btn-delete',function(){
        var id = $(this).data('id');
        var trID = $('#'+id);
        swal({
            title: "Bạn có muốn xóa không ?",
            text: "Sau khi xóa sẽ không thể khôi phục lại!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({

                    type:'delete',
                    url:'/admin/customers/'+id,
                    success : function(reponse){
            
            
            toastr.success('Delete success!');
            $('#customers-table').DataTable().ajax.reload();
        }

       })
                swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Bạn đã hủy chức năng xóa!");
            }
        })
    });


    function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $('.avatar').attr('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            };
            $(document).on('change','.file-upload', function(){
                readURL(this);
            });
});