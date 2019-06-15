$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
	$('#categories-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getCategories',
        columns:[
        	{ data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'slug', name: 'slug' },
            { data: 'parent_id', name: 'parent_id' },
            { data: 'thumbnail', name: 'thumbnail' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action' }
            ]
	})
	$('.btn-add').on('click',function(){
		$('#span_thumbnail_add').html('');
		$('#span_name_add').html('');
		$('#span_description_add').html('');
		$('#span_parent_id_add').html('');
		$('#span_slug_add').html('');


		$('#modal-add').modal('show');
		$('#name_add').keyup(function(){
			var input = $('#name_add').val();
			$('#slug_add').val(to_slug(input));
		})
	})
	$('#form-add').submit(function(e){
		e.preventDefault();
		// var description =textarea_subtring(tinymce.get('description_add').getContent());
		// alert(description);
		
		var data = new FormData();
		data.append('_token',$('meta[name="csrf-token"]').attr('content'));
		data.append('thumbnail',$('#thumbnail_add').val() );
		data.append('name',$('#name_add').val());
		data.append('description',$('#description_add').val());
		data.append('parent_id',$('#parent_id_add').val());
		data.append('slug',$('#slug_add').val());
		$('#span_thumbnail_add').html('');
		$('#span_name_add').html('');
		$('#span_description_add').html('');
		$('#span_parent_id_add').html('');
		$('#span_slug_add').html('');
		$.ajax({
			type:'post',
			url:'/admin/categories',
			data: data,
			contentType: false,
			processData:false,
			success : function(reponse){
				// window.location.reload();
				toastr.success('Add success!');
				$('#modal-add').modal('hide');
				$('#categories-table').DataTable().ajax.reload();

				$('#name_add').val('')
				$('#parent_id_add').val('')
				$('#slug_add').val('')
				$('#thumbnail_add').val('')
				$('#description_add').val('')
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
	$(document).on('click','.btn-show',function(){
		var id = $(this).data('id');
		$('#modal-show').modal('show');
		$.ajax({
			type:'get',
			url:'/admin/categories/'+id,
			success :function(reponse){
				$('#category_id').html(reponse.id);
				$('#category_name').html(reponse.name);
				$('#category_thumbnail').html(reponse.thumbnail);
				$('#category_description').html(reponse.description);
				$('#category_slug').html(reponse.slug);
				$('#category_parent_id').html(reponse.parent_id);

			}
		})
	})
	$(document).on('click','.btn-edit',function(){
		 var id = $(this).data('id');
		 $('#span_thumbnail_update').html('');
		$('#span_name_update').html('');
		$('#span_description_update').html('');
		$('#span_parent_id_update').html('');
		$('#span_slug_update').html('');
		
		 $('#modal-update').modal('show');
		 $('#name_update').keyup(function() {
		var takedata = $('#name_update').val()
		$('#slug_update').val(to_slug(takedata));
		});
		 $.ajax({
		 	type:'get',
		 	url:'/admin/categories/'+id+'/edit',
		 	success:function(reponse){
		 		$('#id_update').val(reponse.id);
		 		$('#name_update').val(reponse.name);
				$('#thumbnail_update').val(reponse.thumbnail);
		 		$('#description_update').val(reponse.description);
		 		$('#slug_update').val(reponse.slug);
		 		$('#parent_id_update').val(reponse.parent_id);
		 	}
		 })
	})

	$('#form-update').submit(function(e){
		e.preventDefault();
		var data = $('#form-update').serialize();
		var id = $('#id_update').val();
		
		$('#span_thumbnail_update').html('');
		$('#span_name_update').html('');
		$('#span_description_update').html('');
		$('#span_parent_id_update').html('');
		$('#span_slug_update').html('');
		$.ajax({
			type:'put',
			url:'/admin/categories/'+id,
			data:data,
		success:function(reponse){
				toastr.success('Update success!');
				$('#modal-update').modal('hide');
				$('#categories-table').DataTable().ajax.reload();
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
				url:'/admin/categories/'+id,
				success : function(reponse){
       					if(reponse.error==true){
                            toastr.error(reponse.message);
                        }
                        else{
                        	$('#categories-table').DataTable().ajax.reload();
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



function textarea_subtring(string){
	string =string.replace(/(\/)/g,'');
	string =string.replace(/(<p>)/g,'');
	
	return string;
}
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
// function readURL(input) {
// 				if (input.files && input.files[0]) {
// 					var reader = new FileReader();

// 					reader.onload = function (e) {
// 						$('.avatar').attr('src', e.target.result);
// 					}

// 					reader.readAsDataURL(input.files[0]);
// 				}
// 			};
// 			$(document).on('change','.file-upload', function(){
// 				readURL(this);
// 			});
});