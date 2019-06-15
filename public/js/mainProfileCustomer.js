$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
   
	
    $(document).on('click','.btn-edit',function(){
        $('#update').toggle()
         $('#span_thumbnail_update').html('');
        $('#span_name_update').html('');
        $('#span_email_update').html('');
        $('#span_password_update').html('');
        $('#span_birthday_update').html('');
        $('#span_mobile_update').html('');
        $('#span_address_update').html('');

        
        
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
            url:'/customer/customers/'+id,
            data:data,
            contentType:false,
            processData:false,
            success:function(reponse){
                toastr.success('Update success!');
                $('#update').toggle();
                $('.thumbnail').attr('src','/storage/'+reponse.thumbnail)
                $('#name').html(reponse.name)
                $('#mobile').html(reponse.mobile)
                $('#address').html(reponse.address)
                $('#email').html(reponse.email)
                $('#created_at').html(reponse.created_at)
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