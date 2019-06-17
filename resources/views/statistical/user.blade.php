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
						<th>Mobile</th>
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
	<div class="modal fade" id="modal-view">
		<div style="width:80%;" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom: 0px;">
					
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4  >Giỏ hàng :</h4>
					

				</div>
				<div class="modal-body">
					<div style="text-align: center;" id="error_messages"></div>
					<div style="margin: auto; text-align: center; width: 100%;">
						<table style="width: 100%;" class="table" id="cart-table">
							<thead >
								<tr>
									<th>Product name</th>
									<th>Price Sale</th>
									<th>Quantity Buy</th>
									
									<th>Total</th>
									<th>Created at</th>
								</tr>
							</thead>
						</table>
					</div>

				</div>
				<div class="clear"></div>
				
				
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
				</div>
			</div>
		</div>
	</div>
	


	

</div>
	


@endsection
@section('js')

<script type="text/javascript" src="/js/mainUserSatistical.js"></script>
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection