$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){

	$('#roles-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getRoles',
        columns:[
        { data: 'id', name: 'id' },
        { data: 'display_name', name: 'display_name' },
        { data: 'description', name: 'description' },
        { data: 'action', name: 'action' },
        ]
    });

    $('.btn-add').on('click',function(){
        
        $('#modal-add').modal('show');
        
        $('#span_name_add').html('');
        $('#span_display_name_add').html('');
        $('#span_description_add').html('');


    })
    $('#form-add').submit(function(e){
        e.preventDefault();
        var data = $('#form-add').serialize();
        $('#span_name_add').html('');
        $('#span_display_name_add').html('');
        $('#span_description_add').html('');
        $.ajax({
            type:'post',
            url:'/admin/roles',
            data: data,
            success : function(reponse){
                // window.location.reload();
                toastr.success('Add success!');
                $('#modal-add').modal('hide');
                $('#roles-table').DataTable().ajax.reload();
                
                $('#name_add').val('');
                $('#display_name_add').val('');
                $('#description_add').val('');

            },
            error: function(jq, status , throwE){
                console.log(jq)
                jQuery.each(jq.responseJSON.errors,function(key,value){
                    $('#span_'+key+'_add').html('<p style ="color:red;">'+value+'</p>');
                    toastr.error(value);
                })  
            }
        })
    });
    $(document).on('click','.btn-edit',function(){
        $('#modal-update').modal('show');

        
        $('#span_name_update').html('');
        $('#span_display_name_update').html('');
        $('#span_description_update').html('');
        var id = $(this).data('id');
        $.ajax({
            type:'get',
            url:'/admin/roles/'+id+'/edit',
            success: function(reponse){
                $('#id_update').val(reponse.id);
                $('#name_update').val(reponse.name);
                $('#display_name_update').val(reponse.display_name);
                $('#description_update').val(reponse.description);
            }
        })
    });
    $('#form-update').submit(function(e){
        e.preventDefault();
        var id = $('#id_update').val();
        var data = $('#form-update').serialize();
        $('#span_name_update').html('');
        $('#span_display_name_update').html('');
        $('#span_description_update').html('');
        $.ajax({
            type:'put',
            url:'/admin/roles/'+id,
            data:data,
            success:function(reponse){
                toastr.success('Update success !');
                $('#modal-update').modal('hide');
                $('#roles-table').DataTable().ajax.reload(); 
            },
            error:function(jq,status,throwE){
                jQuery.each(jq.responseJSON.errors,function(key,value){
                    $('#span_'+key+'_update').html('<p style ="color:red;">'+value+'</p>');
                    toastr.error(value);
                })
            }

        })
    })
    ///delete
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
                    url:'/admin/roles/'+id,
                    success : function(reponse){
                        if(reponse.error==true){
                            toastr.error(reponse.message);
                        }
                        else{
                            $('#roles-table').DataTable().ajax.reload();
                            toastr.success('Delete success!');

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
    })

    $(document).on('click','.btn-permission',function(){
        var id = $(this).data('id');
        $('.permissions').prop('checked',false);

        $('#modal-permissions').modal('show');
        //     $('#permissions-table').DataTable({
        //     destroy:true,
        //     processing: true,
        //     serverSide: true,

        //     ajax:'/admin/showPermissions/'+id,
        //     columns:[
        //     { data: 'id', name: 'id' },
        //     { data: 'description', name: 'description' },
        //     { data: 'action', name: 'action' },
        //     ]
        // });
        $.ajax({
            type:'get',
            url:'/admin/getPermissionRole/'+id,
            success : function(reponse){
                $('#role_id').val(id);
                jQuery.each(reponse,function(key,value){
                    // console.log(value.permission_id)
                    $('#permission'+value.permission_id).prop('checked',true);
                })
                
            }
        })
        
        
    })
    $('#form-role').submit(function(e){
        e.preventDefault();
        var dem =0 ;
        var data = new FormData();
        data.append('_token',$('meta[name="csrf-token"]').attr('content'));
        data.append('role_id',$('#role_id').val());
        jQuery.each($('input[name="permission_id"]:checked'),function(){
            
            data.append(dem,$(this).val());
            dem++;
             // console.log(dem);
        })
        data.append('dem',dem);
        // console.log('Tổng:'+dem);
         $.ajax({
            type:'post',
            url:'/admin/addPermissionRol',
            data:data,
            contentType: false,
            processData:false,
            success: function(reponse){
                jQuery.each(reponse,function(key,value){
                    $('#permission'+value.permission_id).prop('checked',true);
                })

                toastr.success('Update permission success !')
            },
            error:function(jq,status,throwE){
                jQuery.each(jq.responseJSON.errors,function(key,value){
                    toastr.error(value);
                })
            }
         })
    })
});