$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(function(){
   var quantity=0;
    
    // update cart
    $(document).on('click','.btn-update_cart',function(){
        var rowId= $(this).data('id');

         $('#modal-update_cart').modal('show');
        $('#span_quantity_buy_update').html('');
         $.ajax({
            type:'get',
            url:'/product/saleonline/'+rowId+'/edit',
            success: function(reponse){
                $('#quantity_buy_update').val(reponse.cart.qty);
                quantity=reponse.product.quantity;
                $('#quantity_remaining_update').html(quantity);
                $('#rowId').val(reponse.cart.rowId);
                $('#product_id_update').val(reponse.product.id);

                $('#quantity_buy_update').keyup(function(){
                    if($(this).val()>quantity){
                         toastr.error('Số lượng mua bạn vừa lớn hơn số lượng còn trong kho !');
                          $(this).val(quantity);
                    }
                })

            }
         })
    })

    // submit update cart
    $('#form-update_cart').submit(function(e){
        e.preventDefault();
        var data = $(this).serialize()
        $('#span_quantity_buy_update').html('');
        var rowId= $('#rowId').val();
        $.ajax({
            type:'put',
            url:'/product/saleonline/'+rowId,
            data:data,
            success:function(reponse){
                if(reponse.error==true){
                    toastr.error(reponse.messages);
                }
                else{
                 toastr.success(reponse.messages); 
                 $('#modal-update_cart').modal('hide');
                 $('#quantity'+rowId).html(reponse.cart.qty);
                 $('#cart-count').html(reponse.count);
                 $('#error_messages').children().remove();
                 $('.total-span').html(reponse.total)
                }
            },
            error: function(jq,status,throwE){
                jQuery.each(jq.responseJSON.errors,function(key,value){
                    $('#span_'+key+'_add').html('<p style ="color:red;">'+value+'</p>');
                    toastr.error(value);
                })
            }
        })
    })


    $(document).on('click','.btn-delete',function(){
        var id = $(this).data('id');

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
                    url:'/product/saleonline/'+id,
                    success : function(reponse){
                    $('.total-span').html(reponse.total)
                     toastr.success('Delete success!');
                    $('#tr'+id).remove();
                    $('#cart-count').html(reponse.count);
                            
           
        }

       })
                swal("Poof! Your imaginary file has been deleted!", {
                                    icon: "success",
                                });
            } else {
                swal("Bạn đã hủy chức năng xóa!");
            }
        })
    });

// delete all cart ////////////////////////////////////////





    $(document).on('click','#btn-delete_cart',function(){
        var rowId="dsdsdsdsdsdsds";
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
                    url:'/product/delete',
                    success : function(reponse){
                    $('.total-span').html(reponse.total)
                     toastr.success('Delete cart success!');
                    $('#tbody-cart').children().remove();
                    $('#cart-count').html(reponse.count);
                            
           
        }

       })
                swal("Poof! Your imaginary file has been deleted!", {
                                    icon: "success",
                                });
            } else {
                swal("Bạn đã hủy chức năng xóa!");
            }
        })
    });



    
    $('#form-add_order').submit(function(e){
        e.preventDefault();
         $('#span_customer_name').html('');
        $('#span_customer_address').html('');
        $('#span_customer_mobile').html('');
        $('#span_customer_id').html('');
        $('#span_customer_email').html('');
        $('#error_messages').children().remove();
        var data = $('#form-add_order').serialize();
        $.ajax({
            type:'post',
            url:'/product/orderonline',
            data:data,
            success: function(reponse){
                if(reponse.error==true){
                    jQuery.each(reponse.messages,function(key, value){
                          $('#span_'+key+'').html('<p style="color:red;">'+value+'</p>');
                        toastr.error(value);
                      
                    })
                  
                }
                else{
                    if(reponse.error_cart==true){
                        toastr.error(reponse.message);
                    }
                    else{
                        if(reponse.error_quantity==true){
                        console.log(reponse.messages)

                        jQuery.each(reponse.messages,function(key,value){
            toastr.error('id :'+value.cart_id+'<br>Tên :'+value.cart_name+'<br>Số lượng hiện tại còn :'+value.quantity+'. <br>Vui lòng cập nhật giỏi hàng !');       
                        $('#error_messages').append(`<p style="color:red;">Id: `+value.cart_id+` Tên sản phẩm: `+value.cart_name+` Số lượng chỉ còn:`+value.quantity+`</p>`)
                        })

                        
                    }
                    else{
                         toastr.success('Order success !');
                         $('#customer_name').val('')
                         $('#customer_address').val('')
                         $('#customer_mobile').val('')
                         $('#customer_id').val('')
                         $('#customer_email').val('')
                         $('#error_messages').children().remove();
                          $('.total-span').html('')
                            $('#tbody-cart').children().remove();
                    }
                }
                   
                }
            },
            error: function(jq,status, throwE){
                jQuery.each(jq.responseJSON.errors,function(key, value){

                    $('#span_'+key+'').html('<p style="color:red;">'+value+'</p>');
                    toastr.error(value);
                })
            }

        })
    })

});
 