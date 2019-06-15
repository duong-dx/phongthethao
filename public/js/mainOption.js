$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
   
	$('#options-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getOptions',
        columns:[
        	{ data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'action', name: 'action' }
            ]
	});
    
    $(document).on('click','.btn-show',function(){
        $('#modal-show').modal('show'); 
        var id_option= $(this).data('id');
        $('#option_values').DataTable({
        processing: true,
        serverSide: true,
        ajax:'/admin/option_vlaues/'+id_option,
        columns:[
            { data: 'id', name: 'id' },
            { data: 'option_name', name: 'option_name' },
            { data: 'code', name: 'code' },
            { data: 'value', name: 'value' },
            ]
    })
    })
    $('.btn-add').on('click',function(){
        $('#modal-add').modal('show');
    })
    $('#form-add').submit(function(e){
        e.preventDefault();
        var data = $('#form-add').serialize();
        $('#span_name_add').html('');
        $.ajax({
            type:'post',
            url:'/admin/options',
            data:data,
            success: function(reponse){
               toastr.success('Add success!');
                $('#modal-add').modal('hide');
                $('#options-table').DataTable().ajax.reload(); 
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
        var id = $(this).data('id');
        
        $.ajax({
            type:'get',
            url:'/admin/options/'+id+'/edit',
            success:function(reponse){
                $('#id_update').val(reponse.id);
                $('#name_update').val(reponse.name);
            }
        })
    })
    $('#form-update').submit(function(e){
        e.preventDefault();
        var id = $('#id_update').val();
        var data = $('#form-update').serialize();
                $('#span_name_update').html('');

        $.ajax({
            type:'put',
            url:'/admin/options/'+id,
            data:data,
            success:function(reponse){
                    toastr.success('Update success !');
                    $('#modal-update').modal('hide');
                   $('#options-table').DataTable().ajax.reload(); 
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
                url:'/admin/options/'+id,
                success : function(reponse){
            
                    $('#options-table').DataTable().ajax.reload();
                    toastr.success('Delete success!');
            }

       })
                swal("Poof! Your imaginary file has been deleted!", {
                    icon: "success",
                });
            } else {
                swal("Bạn đã hủy chức năng xóa!");
            }
        })
    })
});