@extends('layouts.master2')
@section('css')
<link href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('/css/cssProfile.css') }}">
@endsection
@section('content')

<header class="site-header"></header>
<div class="cover-photo"><img style="width: 100%;height: 100%;" src="/storage/user_thumbnail/tong-hop-anh-bia-facebook-dep-y-nghia-chat-kich-thuoc-chuan-34.jpg
	"></div>
	<div class="body">
		<section style="width: 25%;" class="left-col user-info">
			<div class="profile-avatar">
				<div class="inner">
					@if(Auth::guard('customer')->user()->thumbnail!=null)
					<img class="thumbnail" style="width: 100%;height: 100%;" src="/storage/{{ Auth::guard('customer')->user()->thumbnail }}">
					@else
					<img style="width: 100%;height: 100%;" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail">
					@endif
				</div>
			</div>
			<h1 id="name" style="margin: 3%;">{{ Auth::guard('customer')->user()->name }}</h1>
			<h2 id="mobile" style="margin: 3%;">
				@if( Auth::guard('customer')->user()->mobile!=null )
				{{ Auth::guard('customer')->user()->mobile }}
				@endif
			</h2>
			<div class="meta">
				<p style="margin: 2px;"><i class="fa fa-fw fa-map-marker"></i> 
					<span id="address">
						@if( Auth::guard('customer')->user()->address!=null )
						{{ Auth::guard('customer')->user()->address }}
						@endif
					</span>
				</p>
				<p style="margin: 2px;"><i class="fa fa-fw fa-link"></i>
					 <span id="email">
							@if( Auth::guard('customer')->user()->email!=null )
							{{ Auth::guard('customer')->user()->email }}
							@endif
					</span>
				</p>
				<p style="margin: 2px;"><i class="fa fa-fw fa-clock-o"></i>
					<span id="created_at">
						 @if( Auth::guard('customer')->user()->created_at!=null )
							{{ date('F d, Y', strtotime(Auth::guard('customer')->user()->created_at)) }}
						@endif
				</span>
			</p>
			</div>
			<a href="javascript:;" data-id="{{ Auth::guard('customer')->user()->id }}" class="btn btn-warning btn-edit"><i class="fas fa-user-edit"></i></a>
		</section>
		<section class="section center-col content">

			<!-- Nav -->
			<nav class="profile-nav">
				<ul>
					<li class="active">Activity</li>
					<li>Looks</li>
					<li>Hyped</li>
					<li>Loved</li>
					<li>Collections</li>
				</ul>
			</nav>
			<div style="margin-top: 5%;">
				@foreach($orders as $order)
				
				<h6  style="margin: 2%;">Thời gian :<span style="margin: 1%;">{{ date('F d, Y', strtotime($order->created_at))}}</span></h6>
				<p  style="margin: 2%;">Trạng thái :<span style="margin: 1%;">{{ $order->status_name }}</span></p>
				<div style="margin: 2%;">
					<table class="table">
						<thead class="table-head">
							
							<th >Thumbnail</th>
							
							<th>Product</th>
							<th>Memory</th>
							<th>Color</th>
							<th>Price</th>
							<th>Quantity</th>
							
						</thead>
						<tbody id="tbody-cart">
							@foreach($order->detail_orders as $detail_order)
							<tr  class="table-row">
								
								<td class="column-1">
									<div class="cart-img-product b-rad-4 o-f-hidden">
										<img src="/storage/{{ $detail_order->thumbnail }}" alt="IMG-PRODUCT">
									</div>
								</td>
								<td >{{ $detail_order->product_name }}</td>
								<td >{{ $detail_order->memory }}</td>
								<td >{{ $detail_order->color_name }}</td>
								<td >{{ number_format($detail_order->sale_price) }}</td>
								<td  >{{ $detail_order->quantity_buy }}</td>
								
							</tr>
							@endforeach
						</tbody>
						
					</table>
				</div>

				@endforeach
			</div>

		</section>
		<div class="pagination flex-m flex-w p-t-26">
			{!! $orders->links() !!}
		</div>

	</div>
	<div style="clear: both;" ></div>

	{{-- modal update --}}
	<div style="display: none" id="update">
		<form action="" id="form-update" method="POST" role="form">
						@csrf
						<div class="modal-header">
							<h4 class="modal-title">Edit customer</h4>
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							
						</div>
						<div style="width: 30%;float: left; margin: 5%; text-align: center;" >
								<div style="width: 80%;height: 80%; margin: auto;">
									@if(Auth::guard('customer')->user()->thumbnail==null)
									
										<img class="thumbnail" style="margin: 5% 0% 5% 0% ; width: 100%; height: 100%; border-radius: 50%;" src="http://ssl.gstatic.com/accounts/ui/avatar_2x.png" class="avatar img-circle img-thumbnail" alt="avatar">
									@else
										<img class="thumbnail" style="margin: 5% 0% 5% 0% ; width: 100%; height: 100%; border-radius: 50%;" src="/storage/{{ Auth::guard('customer')->user()->thumbnail }}" alt="avatar">
									@endif
									
								</div>
								<div class="clear"></div>
                				<span id="span_thumbnail_add"></span>
                				<div  class="form-group">
								
								<input type="file"  class="form-control text-center center-block file-upload" name ="thumbnail" id="customer_thumbnail_update"  placeholder="Thumbnail">
								<span id="span_thumbnail_update"></span>
							</div>
						</div>
						<div style="width: 58%;float: left;" class="modal-body">
							
							
							<input type="hidden" name="_method" id="put_update" value="put">
							<input type="hidden" name="id" value="{{ Auth::guard('customer')->user()->id }}" id="customer_id_update">
							
							<div class="form-group">
								<label for="">* Name</label>
								<input type="text" class="form-control" value="{{ Auth::guard('customer')->user()->name }}" id="customer_name_update" name ="name" placeholder="Name">
								<span id="span_name_update"></span>

							</div>
							<div class="form-group">
								<label for="">* Birthday</label>
								<input type="date" class="form-control" id="customer_birthday_update" value="{{ Auth::guard('customer')->user()->birthday }}" name ="birthday" placeholder="Birthday">
								<span id="span_birthday_update"></span>
							</div>
							<div class="form-group">
								<label for="">* Address</label>
								<input type="text" class="form-control" id="customer_address_update" value="{{ Auth::guard('customer')->user()->address }}" name ="address" placeholder="Address">
								<span id="span_address_update"></span>
							</div>
							<div class="form-group">
								<label for="">* Mobile</label>
								<input type="text" class="form-control" id="customer_mobile_update" name ="mobile" value="{{ Auth::guard('customer')->user()->mobile }}" placeholder="Mobile">
								<span id="span_mobile_update"></span>
							</div>
							<div class="form-group">
								<label for="">* Email</label>
								<input type="email" class="form-control" id="customer_email_update" name ="email" value="{{ Auth::guard('customer')->user()->email }}" placeholder="Email">
								<span id="span_email_update"></span>
							</div>
							
							<div class="form-group">
								<label for="">* Password</label>
								<input type="password" class="form-control" id="customer_password_update" name ="password" value="{{ Auth::guard('customer')->user()->password }}" placeholder="Password">
								<span id="span_password_update"></span>
							</div>
						</div>
						<div style="clear: both;" class="clear"></div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit"  class="btn btn-primary">Add</button>
						</div>
		</form>
			
	</div>
<div style="clear: both;" class="clear"></div>


	
	@endsection
	@section('js')
	<script type="text/javascript" src="{{ asset('/js/mainProfileCustomer.js') }}"></script>
	@endsection