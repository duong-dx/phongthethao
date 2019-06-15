$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
  
	$('#orders-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/getOrders',
        columns:[
            { data: 'id', name: 'id' },
            { data: 'customer_name', name: 'customer_name' },
            { data: 'customer_address', name: 'customer_address' },
            { data: 'customer_mobile', name: 'customer_mobile' },
            { data: 'status', name: 'status' },
            { data: 'action', name: 'action' },
            ]
	});



    // show detail_order
    $(document).on('click','.btn-detail_orders',function(){
        $('#modal-detail_orders').modal('show');
        var id = $(this).data('id');
        $('#detail_orders-table').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:'/admin/getDetailOrder/'+id,
            columns:[
                { data: 'product_name', name: 'product_name' },
                { data: 'thumbnail', name: 'thumbnail' },
                { data: 'memory', name: 'memory' },
                { data: 'color_name', name: 'color_name' },
                { data: 'sale_price', name: 'sale_price' },
                { data: 'quantity_buy', name: 'quantity_buy' },
                { data: 'total', name: 'total' }
            ]
        });

    })
    // ###################################################################
    // edit status
    $(document).on('click','.btn-edit',function(){
         $('#reason_reject_update').css('display','none');
        $('#modal-update').modal('show');
         $('#span_status_update').html('');
        $('#span_reason_reject_update').html('');
        var id = $(this).data('id');
        $.ajax({
            type:'get',
            url:'/admin/orders/'+id+'/edit',
            success: function(reponse){
                $('#status_update').val(reponse.status);
                $('#id_update').val(reponse.id)
            }
        })
    });
    $('#form-update').submit(function(e){
        e.preventDefault();
        var id = $('#id_update').val();
        var data = $('#form-update').serialize();
        $('#span_status_update').html('');
        $('#span_reason_reject_update').html('');
        $.ajax({
            type:'put',
            url:'/admin/orders/'+id,
            data:data,
            success:function(reponse){
                if (reponse.error==true) {
                     jQuery.each(reponse.messages,function(key,value){
                        $('#span_'+key+'_update').html('<p style ="color:red;">'+value+'</p>');
                        toastr.error(value);
                    })
                }
                else{
                   toastr.success('Update success !');
                    $('#modal-update').modal('hide');
                   $('#orders-table').DataTable().ajax.reload();  
                   $('#reason_reject').val('');
                }
                    
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
   $('#status_update').change(function(){
        if($('#status_update').val()==4){
            $('#reason_reject_update').css('display','block');
        }
        else{
            $('#reason_reject_update').css('display','none');
        }
        
   })
   // lý do hủy 
   $(document).on('click', '.btn-reason_reject', function(){
        var id= $(this).data('id');
        $('#modal-reason_reject').modal('show');

        $.ajax({
            type:'get',
            url:'/admin/orders/'+id,
            success: function(reponse){
                $('#reason_reject_show').html(reponse.reason_reject);
            }
        })
   })

   // tạo hóa đơn 
   $(document).on('click', '.btn-bill',function(){
    var id = $(this).data('id');
    $('#modal-bill').modal('show');
    $('#tbody-bill-table').children().remove();
    $.ajax({
        type:'get',
        url:'/admin/getBill/'+id,
        success: function(reponse){
            
            var total = 0;
             $('#customer_name').html(reponse.order.customer_name)
                $('#customer_mobile').html(reponse.order.customer_mobile)
                $('#customer_address').html(reponse.order.customer_address)
            jQuery.each(reponse.detail_order, function(key, value){
                total+= value.total
                $('#tbody-bill-table').append(
                    `<tr>
                        <td> <span style="margin: 2%;" >`+value.product_name+`</span></td>
                        <td> <span style="margin: 2%;" >`+value.memory+`</span></td>
                        <td> <span style="margin: 2%;" >`+value.color_name+`</span></td>
                        <td> <span style="margin: 2%;" >`+addCommas(value.sale_price)+`</span>VNĐ</td>
                        <td> <span style="margin: 2%;" >`+value.quantity_buy+`</td>
                        <td> <span style="margin: 2%;" >`+addCommas(value.total)+`</span>VNĐ</td>
                                            
                    </tr>`);

                
            })
            $('#total').text(addCommas(total))
            
        }
    })

   })
   //number format
   function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
});