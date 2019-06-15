@extends('layouts.master')
@section('content')

<div style="font-size: 15px !important;" class="container">
	
	<h4 style="margin: 5% 0% 2% 0%; ">Order</h4>
	{{-- <button class="btn btn-dark btn-add">Add category</button> --}}
	<div class="table-responsive">
		<table style="text-align: center;" class="table table-bordered" id="orders-table">
		        <thead >
		            <tr>
		                <th>Id</th>
		                <th>Customer name</th>
		                <th>Customer address</th>
		                <th>Customer mobile</th>
		                <th>Status</th>
		                <th>Action</th>
		            </tr>
		        </thead>
    	</table>
		<div class="clear"></div>
	</div>
	


	{{-- modal detail_order --}}

	<div class="modal fade" id="modal-detail_orders">
		<div style="width:80%;" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom: 0px;">
					
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4  >Chi tiết sản phẩm :</h4>
					

				</div>
				<div class="modal-body">
					
					<div style="margin: auto; text-align: center; width: 95%;">
						<table class="table" id="detail_orders-table">
							<thead >
								<tr>
									<th>Product name</th>
									<th>Thumbnail</th>
									<th>Price Sale</th>
									<th>Quantity</th>
									<th>Total</th>
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
	
	{{-- modal update  --}}
		<div class="modal fade" id="modal-update">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-update" method="category" role="form">
						@csrf
						<input type="hidden" name="id" id="id_update">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Edit Option</h4>
						</div>
						<div class="clear"></div>
						<div class="modal-body">
							
							<div class="form-group">
								<label for="">* Status</label>
								<select type="text" class="form-control" id="status_update"  name ="status" >
									@foreach($statuses as $status)
									<option value="{{ $status->code }}">{{ $status->name }}</option>
									@endforeach
								</select> 
								<span id="span_status_update"></span>
							</div>
							<div style="display: none;" id="reason_reject_update" class="form-group">
								<label for="">* Reason reject</label>
								<input  type="text" class="form-control" id="reason_reject" name="reason_reject" placeholder="Lý do hủy">
								<span id="span_reason_reject_update"></span>
							</div>
							
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit"  class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>


		{{-- modal lý do hủy --}}
		<div class="modal fade" id="modal-reason_reject">
			<div  class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="padding-bottom: 0px;">
						
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4  >Lý do hủy đơn hàng :</h4>
						

					</div>
					<div class="modal-body">
						
						<div  style="margin: auto; text-align: center; width: 90%;">
							<p style="color: red; font-size: 18px;" id="reason_reject_show"></p>
						</div>

					</div>
					<div class="clear"></div>
					<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							
					</div>
				</div>
			</div>
		</div>
		{{-- modal bill --}}
		<div class="modal fade" id="modal-bill">
			<div style="width: 70%;" class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="padding-bottom: 0px;">
						
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4  >Hóa đơn</h4>
						

					</div>
					<div class="modal-body">
						
						<div  style="margin: auto;  width: 90%;">
							<div style="text-align: center;">
								<h4>Cộng hòa xã hội chủ nghĩa Việt Nam</h4>
								<p>Độc lập - Tự do - Hạnh phúc</p>

								<h3 style="margin: 2% auto 2%;">Hóa Đơn Bán Hàng</h3>
							</div>
							<p >Tên khách hàng:<span style="margin: 2%;"id="customer_name"></span></p>
							<p >Số điện thoại:<span style="margin: 2%;"id="customer_mobile"></span></p>
							<p >Địa chỉ :<span style="margin: 2%;"id="customer_address"></span></p>
							
							<div>
								<table class="table" >
									<thead >
										<tr>
											<th>Product name</th>
											<th>Price Sale</th>
											<th>Sale</th>
											<th>Quantity</th>
											<th>Total</th>
										</tr>
									</thead>
									<tbody id="tbody-bill-table">
										
									</tbody>
								</table>

							</div>
							<h4>Tổng đơn hàng :<span style="margin: 1%;" id="total"></span>VNĐ</h4>
							
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

<script type="text/javascript" src="/js/mainOrder.js"></script>
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection