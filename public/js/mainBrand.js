$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
	$('#brands-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getBrands',
        columns:[
        	{ data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'thumbnail', name: 'thumbnail' },
            { data: 'slug', name: 'slug' },
            { data: 'origin', name: 'origin' },
            { data: 'action', name: 'action' }
            ]
	});


    $('.btn-add').on('click',function(e){
        $('#span_thumbnail_add').html('');
        $('#span_name_add').html('');
        $('#span_origin_add').html('');
        $('#span_slug_add').html('');
        
        $('#modal-add').modal('show')
        $('#name_add').keyup(function() {
        var takedata = $('#name_add').val()
        $('#slug_add').val(to_slug(takedata));

        });
    })
    $('#form-add').submit(function(e){
        e.preventDefault();
        // var formData = $('#form-add').serialize();
        var data = new FormData();
        data.append('_token',$('meta[name="csrf-token"]').attr('content'));
        data.append('thumbnail',$('#thumbnail_add')[0].files[0] );
        data.append('name',$('#name_add').val());
        data.append('origin',$('#origin_add').val());
        data.append('slug',$('#slug_add').val());
        $('#span_thumbnail_add').html('');
        $('#span_name_add').html('');
        $('#span_origin_add').html('');
        $('#span_slug_add').html('');
        $.ajax({
            type:'post',
            url:'/admin/brands',
            data: data,
            contentType: false,
            processData:false,
            success : function(reponse){
                toastr.success('Add success!');
                $('#brands-table').DataTable().ajax.reload();
                $('#modal-add').modal('hide');

                $('.img-thumbnail').attr('src','/storage/default_image.png');
                $('#name_add').val('')
                $('#slug_add').val('')
                $('#origin_add').val('')
                $('#thumbnail_add').val('')
               
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
    // Edit 
    $(document).on('click','.btn-edit',function(){
         var id = $(this).data('id');

         $('#span_thumbnail_update').html('');
        $('#span_name_update').html('');
        $('#span_origin_update').html('');
        $('#span_slug_update').html('');

         $('#modal-update').modal('show');
         $('#name_update').keyup(function() {
        var takedata = $('#name_update').val()
        $('#slug_update').val(to_slug(takedata));
        });
         $.ajax({
            type:'get',
            url:'/admin/brands/'+id+'/edit',
            success:function(reponse){
                $('#id_update').val(reponse.id);
                $('#name_update').val(reponse.name);
                if(reponse.thumbnail!=null){
                    $('#img_thumbnail_update').attr("src","/storage/"+reponse.thumbnail+"");
                }
                else{
                    $('#img_thumbnail_update').attr("src","/storage/default_image.png");
                }
                $('#origin_update').val(reponse.origin);
                $('#slug_update').val(reponse.slug);
                // $('#parent_id_update').val(reponse.parent_id);
            }
         })
    })
    $('#form-update').submit(function(e){
        e.preventDefault();
        var data = new FormData();
        var id = $('#id_update').val();

        data.append('_token',$('meta[name="csrf-token"]').attr('content'));
        data.append('thumbnail',$('#thumbnail_update')[0].files[0] );
        data.append('name',$('#name_update').val());
        data.append('origin',$('#origin_update').val());
        data.append('slug',$('#slug_update').val());
        data.append('_method',$('#put').val());
        data.append('id',$('#id_update').val());
        $('#span_thumbnail_update').html('');
        $('#span_name_update').html('');
        $('#span_origin_update').html('');
        $('#span_slug_update').html('');
        $.ajax({
            type:'post',
            url:'/admin/brands/'+id,
            data:data,
            contentType:false,
            processData:false,
        success:function(reponse){
                toastr.success('Update success!');

                $('#modal-update').modal('hide');
                $('#brands-table').DataTable().ajax.reload();
                 
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
                    url:'/admin/brands/'+id,
                    success : function(reponse){
                         if(reponse.error==true){
                                        toastr.error(reponse.message);
                                    }
                        else{
                                             $('#brands-table').DataTable().ajax.reload();
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
    $(document).ready( function () {
    $('#myTable').DataTable();
} );
    //////////////////
    function to_slug(str)
{
    // Chuyển hết sang chữ thường
    str = str.toLowerCase();     
 
    // xóa dấu
    str = str.replace(/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/g, 'a');
    str = str.replace(/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/g, 'e');
    str = str.replace(/(ì|í|ị|ỉ|ĩ)/g, 'i');
    str = str.replace(/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/g, 'o');
    str = str.replace(/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/g, 'u');
    str = str.replace(/(ỳ|ý|ỵ|ỷ|ỹ)/g, 'y');
    str = str.replace(/(đ)/g, 'd');
 
    // Xóa ký tự đặc biệt
    str = str.replace(/([^0-9a-z-\s])/g, '');
 
    // Xóa khoảng trắng thay bằng ký tự -
    str = str.replace(/(\s+)/g, '-');
 
    // xóa phần dự - ở đầu
    str = str.replace(/^-+/g, '');
 
    // xóa phần dư - ở cuối
    str = str.replace(/-+$/g, '');
 
    // return
    return str;
}
    //////////xem trước ảnh 
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