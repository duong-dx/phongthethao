$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
   
	$('#users-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getUsers',
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
            url:'/admin/users',
            data: data,
            contentType: false,
            processData:false,
            success : function(reponse){
                // window.location.reload();
                toastr.success('Add success!');
                $('#modal-add').modal('hide')
                $('#users-table').DataTable().ajax.reload();

                $('.img-thumbnail').attr('src','http://ssl.gstatic.com/accounts/ui/avatar_2x.png');
                $('#thumbnail_add').val('')
                $('#name_add').val('')
                $('#birthday_add').val('')
                $('#address_add').val('')
                $('#mobile_add').val('')
                $('#email_add').val('')
                $('#password_add').val('')
               
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
            url:'/admin/users/'+id,
            success: function(reponse){
                $('#user_id').html(reponse.id);
                $('#user_name').html(reponse.name);
                $('#user_email').html(reponse.email);
                if(reponse.thumbnail!=null){
                    $('#thumbnail_show').attr("src","/storage/"+reponse.thumbnail+"");
                }
                else{
                    $('#thumbnail_show').attr("src","http://ssl.gstatic.com/accounts/ui/avatar_2x.png");
                }
                $('#user_mobile').html(reponse.mobile);
                $('#user_address').html(reponse.address);
                $('#user_birthday').html(reponse.birthday);
                
                
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
            url:'/admin/users/'+id+'/edit',
            success:function(reponse){
                $('#user_id_update').val(reponse.id);
                $('#user_name_update').val(reponse.name);
                $('#user_email_update').val(reponse.email);
                $('#user_mobile_update').val(reponse.mobile);
                $('#user_birthday_update').val(reponse.birthday);
                $('#user_address_update').val(reponse.address);
                if(reponse.thumbnail!=null){
                    $('#img_thumbnail_update').attr("src","/storage/"+reponse.thumbnail+"");
                }
                else{
                    $('#img_thumbnail_update').attr("src","http://ssl.gstatic.com/accounts/ui/avatar_2x.png");
                }
            }
        })
    })

    $('#form-update').submit(function(e){
        e.preventDefault();
        
        var id = $('#user_id_update').val();
        var data = new FormData();
        data.append('_token',$('meta[name="csrf-token"]').attr('content'));
        data.append('thumbnail',$('#user_thumbnail_update')[0].files[0]);
        data.append('name',$('#user_name_update').val());
        data.append('_method',$('#put_update').val());
        data.append('id',id);
        data.append('email',$('#user_email_update').val());
        data.append('password',$('#user_password_update').val()); 
        data.append('address',$('#user_address_update').val()); 
        data.append('mobile',$('#user_mobile_update').val()); 
        data.append('birthday',$('#user_birthday_update').val()); 
        $('#span_thumbnail_update').html('');
        $('#span_name_update').html('');
        $('#span_email_update').html('');
        $('#span_password_update').html('');
        $('#span_birthday_update').html('');
        $('#span_mobile_update').html('');
        $('#span_address_update').html('');
        $.ajax({
            type:'post',
            url:'/admin/users/'+id,
            data:data,
            contentType:false,
            processData:false,
            success:function(reponse){
                toastr.success('Update success!');
                $('#modal-update').modal('hide');
               $('#users-table').DataTable().ajax.reload();
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
                    url:'/admin/users/'+id,
                    success : function(reponse){
                         if(reponse.error==true){
                            toastr.error(reponse.message);
                        }
                        else{
                             toastr.success('Delete success!');
                            $('#users-table').DataTable().ajax.reload();
                            swal("Poof! Your imaginary file has been deleted!", {
                                    icon: "success",
                                });
                        }
           
        }

       })
                
            } else {
                swal("Bạn đã hủy chức năng xóa!");
            }
        })
    });
    /*#########################################################################################*/
    $(document).on('click','.btn-role',function(){
        $('#modal-role').modal('show');
        var id = $(this).data('id');
        $('#user_id_role').val(id);
        $.ajax({
            type:'get',
            url:'/admin/getRoleUser/'+id,
            success: function(reponse){
                console.log(reponse);
                $('#role_id').val(reponse.role_id);
            }
        })

    })
    $('#form-role').submit(function(e){
        e.preventDefault();
        var data = $('#form-role').serialize();
        
        $.ajax({
            type:'post',
            url:'/admin/addRoleUser',
            data:data,
            success: function(reponse){
                 toastr.success('Update role success !');  
                $('#modal-role').modal('hide');
            },
            error: function(jq, status, throwE){
                jQuery.each(jq.responseJSON.errors,function(key,value){
                   toastr.error(value);  
                })
            }
        })

    })


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