$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
    var memory;
    var slug;
    var quantity;
	$(document).on('click','.btn_memory',function(){
        $('.btn_memory').css('border','solid 1px black');
        memory = $(this).data('id');
        slug =$(this).data('url');
        $(this).css('border','solid 1px red')
        // alert(slug);
         $('#select_color').children().remove();

        $.ajax({
            type:'get',
            url:'/product/'+slug+'/'+memory,
            success: function(reponse){
                jQuery.each(reponse,function(key,value){
                    $('#select_color').append(
                            `<option value="`+value.color_id+`">`+value.color_name+`</option>`
                    );
                    if(key==0){
                       $('#quantity_remaining').html(value.quantity); 
                       $('#detail_product_id').val(value.id);
                    }
                })

                $('#select_color').attr('disabled', false);
            }
        })
    })

    $('#select_color').change(function(){
        // 
        var color_id =$(this).val();
        $.ajax({
            type:'get',
            url:'/product/'+slug+'/'+memory+'/'+color_id,
            success: function(reponse){
                 quantity= reponse.detail_product.quantity;
                $('#detail_product_id').val(reponse.detail_product.id);
                $('#quantity_remaining').html(reponse.detail_product.quantity);
            }
        })
    })


    // submit add to cart
    $('#form-add_to_cart').submit(function(e){
        e.preventDefault();
         var data = $('#form-add_to_cart').serialize();
         $.ajax({
            type:'post',
            url:'/product/saleonline',
            data:data,
            success: function(reponse){
                if(reponse.error==true){
                    toastr.error(reponse.messages);
                }
                else{
                     toastr.success(reponse.messages)
                     $('#modal-add_to_cart').modal('hide');
                     $('#modal-detail_products').modal('show');
                     $('#quantity_buy').val(''); 
                     // swith arlert
                     $('.btn-addcart-product-detail').each(function(){
                        var nameProduct = $('.product-detail-name').html();
                        $(this).on('click', function(){
                            swal(nameProduct, "is added to wishlist !", "success");
                        });
                    });
                     $('#cart-count').html(reponse.count);
                }
                // console.log(reponse.name)
            },
            error: function(jq,status,throwE){
                jQuery.each(jq.responseJSON.errors, function(key, value){
                    toastr.error(value);
                })
            }
         })
    })

});