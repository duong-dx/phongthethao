$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
    var memory;
    var slug;
    var quantity;
	
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