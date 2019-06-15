@extends('layouts.master')
@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('/css/cssThongke.css') }}">
@endsection
@section('content')

<div style="font-size: 15px !important;" class="container">
	
		<section id="what-we-do">
		<div class="container-fluid">
			<h2 class="section-title mb-2 h1">Thống kê sơ bộ </h2>
			<p class="text-center text-muted h5">Having and managing a correct marketing strategy is crucial in a fast moving market.</p>
			<div class="row mt-5">
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-block block-1">
							<h3 class="card-title">Khách hàng</h3>
							<p class="card-text">Số lượng hiện tại :{{ $customer_count }}</p>
							<a href="/admin/customers" title="Read more" class="read-more" >Click hear<i class="fa fa-angle-double-right ml-2"></i></a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-block block-2">
							<h3 class="card-title">Sản phẩm</h3>
							<p class="card-text">Số lượng hiện tại :{{ $product_count }}</p>
							<a href="/admin/products" title="Read more" class="read-more" >Click hear<i class="fa fa-angle-double-right ml-2"></i></a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-block block-3">
							<h3 class="card-title">Nhân Viên</h3>
							<p class="card-text">Số lượng hiện tại :{{ $user_count }}</p>
							<a href="/admin/users" title="Read more" class="read-more" >Click hear<i class="fa fa-angle-double-right ml-2"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-block block-4">
							<h3 class="card-title">Đơn hàng chờ xác nhận</h3>
							<p class="card-text">Số lượng hiện tại :{{ $order_confirm_count }}</p>
							<a href="/admin/orders" title="Read more" class="read-more" >Click hear<i class="fa fa-angle-double-right ml-2"></i></a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-block block-5">
							<h3 class="card-title">Đơn hàng đã thanh toán</h3>
							<p class="card-text">Số lượng hiện tại :{{ $order_paid_count }}</p>
							<a href="/admin/orders" title="Read more" class="read-more" >Click hear<i class="fa fa-angle-double-right ml-2"></i></a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
					<div class="card">
						<div class="card-block block-6">
							<h3 class="card-title">Đơn hàng đã bị hủy</h3>
							<p class="card-text">Số lượng hiện tại :{{ $order_canceled_count }}</p>
							<a href="/admin/orders" title="Read more" class="read-more" >Click hear<i class="fa fa-angle-double-right ml-2"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>	
	</section>

</div>
	


@endsection
@section('js')

{{-- <script type="text/javascript" src="/js/mainSale.js"></script> --}}
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection