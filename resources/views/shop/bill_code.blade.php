@extends('layouts.master2')
@section('css')
<style>
	.form-control-borderless {
    border: none;
}

.form-control-borderless:hover, .form-control-borderless:active, .form-control-borderless:focus {
    border: none;
    outline: none;
    box-shadow: none;
}
</style>
@endsection
@section('content')


	<!-- Content page -->
	<section class="bgwhite p-t-55 p-b-65">
		<div style="width: 80%; margin: auto;" class="container">
			<div class="row justify-content-center">
                        <div class="col-12 col-md-10 col-lg-8">
                            <form class="card card-sm" action="/product/getOrderStatus" method="post">
                            	@csrf
                                <div class="card-body row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <i class="fas fa-search h4 text-body"></i>
                                    </div>
                                    <!--end of col-->
                                    <div class="col">
                                        <input class="form-control form-control-lg form-control-borderless" type="text" name ="code" placeholder="Nhập vào mã hóa đơn">
                                    </div>
                                    <!--end of col-->
                                    <div class="col-auto">
                                        <button class="btn btn-lg btn-success" type="submit">Search</button>
                                    </div>
                                    <!--end of col-->
                                </div>
                            </form>
                        </div>
                        <!--end of col-->
                    </div>

                    <div style="margin-top: 3%;">
                    	@if(isset($code))
	                    	<div style="text-align: center; margin-bottom: 5%;">
	                    		<h3>Thông tin đơn hàng có mã: {{ $code }}</h3>
	                    	</div>
	                    	<h5 style="margin-bottom: 2%;">Tên khách hàng : {{ $order->customer_name }}</h5>
	                    	<h5 style="margin-bottom: 2%;">Số điện thoại : {{ $order->customer_mobile }}</h5>
	                    	<h5 style="margin-bottom: 2%;">Địa chỉ : {{ $order->customer_address }}</h5>
	                    	<h5 style="margin-bottom: 2%;">Email : {{ $order->customer_email }}</h5>
	                    	@if($order->status==4)
	                    	<h5 style="margin-bottom: 2%;"> Trạng thái hóa đơn :<span style="color: red;">{{ $order->status_name }}</span>
	                    	</h5>
	                    	<p >Lý Do Hủy: <span style="color: red;"> {{ $order->reason_reject }}</span></p>
	                    	@endif
	                    	@if($order->status==3)
	                    	<h5 style="margin-bottom: 2%;"> Trạng thái hóa đơn :<span style="color: green;">{{ $order->status_name }}</span>
	                    	</h5>

	                    	@endif
	                    	@if($order->status==1)
	                    	<h5 style="margin-bottom: 2%;"> Trạng thái hóa đơn :<span class="text-warning ">{{ $order->status_name }}</span>
	                    	</h5>

	                    	@endif
	                    	@if($order->status==2)
	                    	<h5 style="margin-bottom: 2%;"> Trạng thái hóa đơn :<span class="text-warning ">{{ $order->status_name }}</span>
	                    	</h5>

	                    	@endif
	                    	@if($order->status==0)
	                    	<h5 style="margin-bottom: 2%;"> Trạng thái hóa đơn :<span class="text-warning ">{{ $order->status_name }}</span>
	                    	</h5>

	                    	@endif
	                    	<div style="text-align: center; margin: 3%;">
	                    	 	<h4>Chi tiết đơn hàng</h4>
	                    	 	</div>
	                    	<table style="width: 100%; text-align: center;" class="table-responsive table-bordered">
	                    		<thead style="width: 100%; text-align: center;" class="thead">
	                    			<th class="column-2">Tên sản phẩm</th>
	                    			<th class="column-1">Ảnh</th>
	                    			<th class="column-5">Giá</th>
	                    			<th class="column-3">Giảm giá</th>
	                    			<th class="column-3">Số lượng mua</th>
	                    			<th class="column-2">Tổng tiền</th>
	                    		</thead>
	                    	
	                    	<tbody style="width: 100%; text-align: center;" class="tbody">
	                    		@php
	                    		$tongtien =0;
	                    		@endphp
	                    		@foreach($order->detail_orders as $detail_order)
	                    		<tr class="table-row">
	                    			<td class="column-2">{{ $detail_order->product_name }}</td>
	                    			<td class="column-1"><img style="width: 60px; height: 60px;" src="/storage/{{ $detail_order->thumbnail }}" alt=""></td>
	                    			<td class="column-5">{{ number_format($detail_order->sale_price) }} VNĐ</td>
	                    			<td class="column-3"><p style="color: green;">Giảm giá :{{ $detail_order->product_sale }}</p>%</td>
	                    			<td class="column-3">{{ $detail_order->quantity_buy }}</td>
	                    			<td class="column-2">{{ number_format($detail_order->total) }} VNĐ</td>
	                    			@php
	                    			$tongtien += $detail_order->total;
	                    			@endphp
	                    		</tr>
	                    		@endforeach
	                    	</tbody>
	                    	</table>
	                    	<h4 style="margin-top: 5%;">Tổng đơn hàng : {{ number_format($tongtien) }} VNĐ</h4>
                    	@endif
                    </div>
			
		</div>
		
	</section>

@endsection
@section('js')
@endsection