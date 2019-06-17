$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});
$(function(){
   var quantity=0;
	$('#list_products-table').DataTable({
		processing: true,
        serverSide: true,
        ajax:'/admin/statistical/getProductStatistical',
        columns:[

            { data: 'name', name: 'name' },
            { data: 'thumbnail', name: 'thumbnail' },
            { data: 'brand_id', name: 'brand_id' },
            { data: 'category_id', name: 'category_id' },
            { data: 'choose', name: 'choose' }
        ]
	});
// hiển thị danh sách giỏ hàng
    $(document).on('click','.btn-view',function(){
        $('#modal-view').modal('show');
       var id =$(this).data('id');
        $('#cart-table').DataTable({
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:'/admin/statistical/product/'+id,
            columns:[
                { data: 'product_name', name: 'product_name' },
                { data: 'sale_price', name: 'sale_price' },
                { data: 'quantity_buy', name: 'quantity_buy' },
                { data: 'total', name: 'total' },
                { data: 'created_at', name: 'created_at' },
            ]
        });
        

    })

    

});