$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
   
	$('#memories-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getMemories',
        columns:[
        	{ data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'code', name: 'code' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action' },
            ]
	});
    $('.btn-add').on('click',function(){
        $('#modal-add').modal('show');
         $('#span_name_add').html('');
        $('#span_code_add').html('');
    })
    $('#form-add').submit(function(e){
        e.preventDefault();
        // var description =textarea_subtring(tinymce.get('description_add').getContent());
        // alert(description);
        var data = $('#form-add').serialize();
        $('#span_name_add').html('');
        $('#span_code_add').html('');
        $.ajax({
            type:'post',
            url:'/admin/memories',
            data: data,
            success : function(reponse){
                // window.location.reload();
                toastr.success('Add success!');
                $('#modal-add').modal('hide');
                $('#memories-table').DataTable().ajax.reload();

                $('#name_add').val('')
                $('#code_add').val('')
               
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
        $('#span_code_update').html('');
        var id = $(this).data('id');
        $.ajax({
            type:'get',
            url:'/admin/memories/'+id+'/edit',
            success: function(reponse){

                $('#name_update').val(reponse.name);
                $('#id_update').val(reponse.id);
                $('#code_update').val(reponse.code);
            }
        })
    });
    $('#form-update').submit(function(e){
        e.preventDefault();
        var id = $('#id_update').val();
        var data = $('#form-update').serialize();
        $('#span_name_update').html('');
        $('#span_code_update').html('');
        $.ajax({
            type:'put',
            url:'/admin/memories/'+id,
            data:data,
            success:function(reponse){
                    toastr.success('Update success !');
                    $('#modal-update').modal('hide');
                   $('#memories-table').DataTable().ajax.reload(); 
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
                url:'/admin/memories/'+id,
                success : function(reponse){
                     if(reponse.error==true){
                            toastr.error(reponse.message);
                        }else{
                             $('#memories-table').DataTable().ajax.reload();
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