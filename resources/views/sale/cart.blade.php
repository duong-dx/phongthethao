@extends('layouts.master')
@section('content')

<div style="font-size: 15px !important;" class="container">
	
	<a style="margin: 5% 0% 2% 0%; " href="/admin/getCart" class="btn btn-dark btn-cart">
		<i class="fas fa-shopping-cart"></i>
	</a>
	<h4 style="margin: 1% 0% 2% 0%; ">Sale</h4>
	{{-- <button class="btn btn-dark btn-add">Add category</button> --}}
	<div class="table-responsive">
		<table style="text-align: center;" class="table table-bordered" id="list_products-table">
		        <thead >
		            <tr>
			            <th>Product name</th>
						<th>Thumbnail</th>
						<th>Memory</th>
						{{-- <th>Color</th> --}}
						<th>Quantity Buy</th>
						<th>Price Sale</th>
						<th>Total</th>
						<th>Action</th>
		            </tr>
		        </thead>
		        <tbody>
		        	@if(Cart::content()!=null)
			        	@foreach(Cart::content() as $cart)
			        	<tr>
			        		<td>{{ $cart->name }}</td>
			        		<td><img style="margin:auto; width:60px; height:60px;" src ="/storage/{{ $cart->options->thumbnail }}">
			        		</td>
			        		<td>{{ $cart->options->memory }}</td>
			        		<td>{{ $cart->qty }}</td>
			        		<td>{{ $cart->price }}</td>
			        		<td>{{ number_format($cart->price*$cart->qty) }}</td>
			        		<td>
			        			<button type="button" title="Cập nhật số lượng mua" class="btn btn-warning btn-update_cart" data-id="{{ $cart->rowId }}"><i class="far fa-edit"></i></button>

	       						<button type="button" title="Hủy sản phẩm" class="btn btn-danger btn-list_detail_products" data-id="{{ $cart->rowId }}"><i class="far fa-trash-alt"></i></button>
			        		</td>
			        	</tr>
			        	@endforeach
			        @endif
		        </tbody>
    	</table>

		
	</div>
{{-- modal update cart --}}
	<div class="modal fade" id="modal-update_cart">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" id="form-update_cart" method="post" role="form" enctype="multipart/form-data">
						@csrf
					<div class="modal-header" style="padding-bottom: 0px;">
						<h4>Số lượng còn : <span id="quantity_remaining"></span></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" readonly name="detail_product_id" id="detail_product_id">
								<label for="">* Số lượng mua</label>
								<input type="number"  class="form-control" name="quantity_buy" id="quantity_buy" placeholder="Nhập vào số lượng mua">
								<span id="span_quantity_buy_add"></span>
						</div>
						
					</div>
					<div class="clear"></div>
					<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit"  class="btn btn-primary">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

</div>
	


@endsection
@section('js')

{{-- <script type="text/javascript" src="/js/mainSale.js"></script> --}}
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection