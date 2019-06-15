@extends('layouts.master')
@section('content')

<div style="font-size: 15px !important;" class="container">
	
	<a style="margin: 5% 0% 2% 0%; " href="javascript:;" class="btn btn-dark btn-cart">
		My cart</i>
	</a>
	
	{{-- <button class="btn btn-dark btn-add">Add category</button> --}}
	<div class="table-responsive">
		<table style="text-align: center;" class="table table-bordered" id="list_products-table">
		        <thead >
		            <tr>
			            <th>Name</th>
			            <th>Thumnail</th>
						<th>Brand name</th>
						<th>Category name</th>
						<th>Choose</th>
		            </tr>
		        </thead>
    	</table>
		<div class="clear"></div>
	</div>
	
	{{-- modal input quantity --}}
	<div class="modal fade" id="modal-add_to_cart">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" id="form-add_to_cart" method="post" role="form" enctype="multipart/form-data">
						@csrf
					<div class="modal-header" style="padding-bottom: 0px;">
						<h4>Số lượng còn : <span id="quantity_remaining"></span></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" readonly name="product_id" id="product_id">
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
	{{-- modal cart --}}
	<div class="modal fade" id="modal-cart">
		<div style="width:80%;" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom: 0px;">
					
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4  >Giỏ hàng :</h4>
					

				</div>
				<div class="modal-body">
					<div style="text-align: center;" id="error_messages"></div>
					<div style="margin: auto; text-align: center; width: 90%;">
						<table class="table" id="cart-table">
							<thead >
								<tr>
									<th>Id</th>
									<th>Product name</th>
									<th>Thumbnail</th>
									<th>Quantity Buy</th>
									<th>Price Sale</th>
									{{-- <th>Total</th> --}}
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>

				</div>
				<div class="clear"></div>
				<h4 id="total_carts" style="margin-left: 5%;margin-top: 1% ; margin-bottom: 1%;">Tổng tiền thanh toán : {{ Cart::instance('admin')->subtotal() }} VNĐ</h4>
				<div style="float: left; width: 50%; text-align: center;">
				<a href="javascript:;" id="btn-delete_cart" class="btn btn-danger"><i class="fas fa-trash"></i>&nbsp&nbspDestroy Cart </a>
				</div>
				<div style="float: left; width: 50%; text-align: center;">
				<a href="javascript:;" id="btn-add_order" class="btn btn-success"><i class="fas fa-check"></i>&nbsp&nbspĐặt ngay</a>
				</div>
				<div class="clear"></div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
				</div>
			</div>
		</div>
	</div>
	{{-- modal update cart --}}
	<div class="modal fade" id="modal-update_cart">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" id="form-update_cart" method="post" role="form" enctype="multipart/form-data">
						@csrf
					<div class="modal-header" style="padding-bottom: 0px;">
						<h4>Số lượng còn : <span id="quantity_remaining_update"></span></h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
							<input type="hidden" readonly name="rowId" id="rowId">
							<input type="hidden" readonly name="detail_product_id" id="detail_product_id_update">
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


{{-- modal add order --}}
	<div class="modal fade" id="modal-add_order">
		<div class="modal-dialog">
			<div class="modal-content">
				<form action="" id="form-add_order" method="post" role="form" enctype="multipart/form-data">
						@csrf
					<div class="modal-header" style="padding-bottom: 0px;">
						<h4>Thông tin :</h4>
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">
						<div class="form-group">
								<label for="">* Customer name</label>
								<input type="text"  class="form-control" name="customer_name" id="customer_name" placeholder="Nhập vào tên khách hàng">
								<span id="span_customer_name"></span>
						</div>
						<div class="form-group">
								<label for="">* Customer address</label>
								<input type="text"  class="form-control" name="customer_address" id="customer_address" placeholder="Nhập vào địa chỉ khách hàng">
								<span id="span_customer_address"></span>
						</div>
						<div class="form-group">
								<label for="">* Customer mobile</label>
								<input type="number"  class="form-control" name="customer_mobile" id="customer_mobile" placeholder="Nhập vào số điện thoại khách hàng">
								<span id="span_customer_mobile"></span>
						</div>
						<div class="form-group">
								<label for="">Customer id</label>
								<input type="number"  class="form-control" name="customer_id" id="customer_id" placeholder="Nhập vào mã khách hàng">
								<span id="span_customer_id"></span>
						</div>
						<div class="form-group">
								<label for="">Customer email</label>
								<input type="text"  class="form-control" name="customer_email" id="customer_email" placeholder="Nhập vào mã khách hàng">
								<span id="span_customer_email"></span>
						</div>
						<input type="hidden" readonly name="user_id" value="{{ Auth::user()->id }}">
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

<script type="text/javascript" src="/js/mainSale.js"></script>
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection