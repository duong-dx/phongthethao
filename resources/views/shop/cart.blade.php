@extends('layouts.master2')
@section('content')
{{--  --}}
{{-- modal update cart --}}
	<div class="modal fade" id="modal-update_cart">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" id="form-update_cart" method="post" role="form" enctype="multipart/form-data">
						@csrf
					<div class="modal-header" style="padding-bottom: 0px;">
						<h4 style="margin-bottom: 2%;margin-top: 2%;">Số lượng còn : <span id="quantity_remaining_update"></span></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" readonly name="rowId" id="rowId">
							<input type="hidden" readonly name="product_id" id="product_id_update">
								<label for="">* Số lượng mua</label>
								<input type="number"  class="form-control" name="quantity_buy" id="quantity_buy_update" placeholder="Cập nhật số lượng mua">
								<span id="span_quantity_buy_update"></span>
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
	{{-- ############################################################################# --}}
	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100">
		<div class="container">
			<!-- Cart item -->
			<div class="container-table-cart pos-relative">
				<div style="text-align: center; " id="error_messages"></div>
				<div class="wrap-table-shopping-cart bgwhite">
					<table class="table-shopping-cart">
						<thead class="table-head">
							
							<th class="column-1">Thumbnail</th>
							<th class="column-3">Id</th>
							<th class="column-2">Product</th>
							<th class="column-5">Price</th>
							<th class="column-3">Sale</th>
							<th class="column-3">Quantity</th>
							<th class="column-2">Action</th>
						</thead>
						<tbody id="tbody-cart">

						@foreach($carts  as $cart)
							<tr id="tr{{ $cart->rowId }}" class="table-row">
								
								<td class="column-1">
									<div class="cart-img-product b-rad-4 o-f-hidden">
										<img src="/storage/{{ $cart->options->thumbnail->thumbnail }}" alt="IMG-PRODUCT">
									</div>
								</td>
								<td  class="column-3">{{ $cart->id }}</td>
								<td class="column-2">{{ $cart->name }}</td>
								<td class="column-5">{{ number_format($cart->price) }}</td>
								<td style="color: green;" class="column-3">Giảm giá: {{ $cart->options->sale }} %</td>
								<td id="quantity{{ $cart->rowId }}" class="column-3">{{ $cart->qty }}</td>
								<td class="column-2"> 
									<a href="javascript:;" data-id="{{ $cart->rowId }}" title="Cập nhật số lượng" class="btn btn-warning btn-update_cart"><i class="far fa-edit"></i></a>
									<a href="javascript:;" data-id="{{ $cart->rowId }}" title="Xóa sản phẩm" class="btn btn-danger btn-delete"><i class="far fa-trash-alt"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
						
					</table>
				</div>
				<h3>Total : <span style="margin: 2%;" class="total-span">{{ Cart::instance('shopping')->subtotal }}</span>VnĐ</h3>
				{{-- tác vụ --}}
				<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
				<div class="flex-w flex-m w-full-sm">
					
					<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
						<!-- Button -->
						<button id="btn-delete_cart" class="flex-c-m sizefull bo-rad-23 hov1 s-text1 trans-0-4 btn-danger">
							<span style="margin:2%;"><i class="fas fa-trash"></i></span>Delete Cart
						</button>
					</div>
				</div>

				<div class="size10 trans-0-4 m-t-10 m-b-10">
					
				</div>
			</div>
			</div>
		{{-- div pay --}}
			<!-- Total -->
			<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">
				<h5 class="m-text20 p-b-24">
					Cart Totals:
					<span style="margin: 2%;" class="total-span">{{ Cart::instance('shopping')->subtotal }}</span> VnĐ
				</h5>

				
				<!--  -->
				<div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<form id="form-add_order">
					@csrf
						<p class="s-text8 p-b-23">
							There are no shipping methods available. Please double check your address, or contact us if you need any help.
						</p>

						

						

						
						<div class="form-group">
								<label for="">* Customer name</label>
								<input style="border:1px solid !important;" type="text" 
									@if(Auth::guard('customer')->user()!=null)
									value="{{ Auth::guard('customer')->user()->name }}" 
								@endif
								 class="form-control" name="customer_name" id="customer_name" placeholder="Nhập vào tên khách hàng">
								<span id="span_customer_name"></span>
						</div>
						<div class="form-group">
								<label for="">* Customer address</label>
								<input style="border:1px solid !important;" type="text"
								@if(Auth::guard('customer')->user()!=null)
									value="{{ Auth::guard('customer')->user()->address
									 }}" 
								@endif
								  class="form-control" name="customer_address" id="customer_address" placeholder="Nhập vào địa chỉ khách hàng">
								<span id="span_customer_address"></span>
						</div>
						<div class="form-group">
								<label for="">* Customer mobile</label>
								<input style="border:1px solid !important;" type="number" 
								@if(Auth::guard('customer')->user()!=null)
									value="{{ Auth::guard('customer')->user()->mobile }}" 
								@endif
								 class="form-control" name="customer_mobile" id="customer_mobile" placeholder="Nhập vào số điện thoại khách hàng">
								<span id="span_customer_mobile"></span>
						</div>
						
								<input style="border:1px solid !important;" type="hidden"
								@if(Auth::guard('customer')->user()!=null)
									value="{{ Auth::guard('customer')->user()->id }}" 
								@endif
								readonly
								 
								  class="form-control" name="customer_id" id="customer_id" placeholder="Nhập vào mã khách hàng">
						
						<div class="form-group">
								<label for="">Customer email</label>
								<input style="border:1px solid !important;" type="text" 
								@if(Auth::guard('customer')->user()!=null)
									value="{{ Auth::guard('customer')->user()->email }}" 
								@endif
								 class="form-control" name="customer_email" id="customer_email" placeholder="Nhập vào mã khách hàng">
								<span id="span_customer_email"></span>
						</div>

						<div class="size14 trans-0-4 m-b-10">
							<!-- Button -->
							<!-- Button -->
							<button id="btn-add_order" class="flex-c-m sizefull btn-success bo-rad-23 hov1 s-text1 trans-0-4 btn-delete-cart">
								<span style="margin:2%;"><i class="fas fa-check"></i></span>
								Pay
							</button>
						</div>
					</form>
				</div>

				<!--  -->
				
			</div>

			
		</div>

	</section>
	
@endsection
@section('js')
	<script type="text/javascript" src="{{ asset('/js/mainCartOnline.js') }}"></script>
@endsection