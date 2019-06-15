$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
   
	$('#permissions-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getPermissions',
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
            url:'/admin/permissions',
            data: data,
            success : function(reponse){
                // window.location.reload();
                toastr.success('Add success!');
                $('#modal-add').modal('hide');
                $('#permissions-table').DataTable().ajax.reload();

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
            url:'/admin/permissions/'+id+'/edit',
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
            url:'/admin/permissions/'+id,
            data:data,
            success:function(reponse){
                    toastr.success('Update success !');
                    $('#modal-update').modal('hide');
                   $('#permissions-table').DataTable().ajax.reload(); 
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
                url:'/admin/permissions/'+id,
                success : function(reponse){
                     if(reponse.error==true){
                            toastr.error(reponse.message);
                        }
                        else{
                            $('#permissions-table').DataTable().ajax.reload();
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
});