@extends('layouts.master2')
<style>
	.card-inner{
    margin-left: 4rem;

}
.avatar{
    	width: 60px;
    	height: 60px;
    	border-radius: 50%;
    }
</style>
@section('content')

	<!-- breadcrumb -->
	{{--  --}}

	<!-- Product Detail -->
	<div class="container bgwhite p-t-35 p-b-80">
		<div class="flex-w flex-sb">
			<div class="w-size13 p-t-30 respon5">
				<div class="wrap-slick3 flex-sb flex-w">
					<div class="wrap-slick3-dots"></div>
					
					<div class="slick3">
						@foreach($product->images as $image)
						
						<div  class="item-slick3" data-thumb="/storage/{{ $image->thumbnail }}">
							<div   class="wrap-pic-w">
								<img src="/storage/{{ $image->thumbnail }}" alt="IMG-PRODUCT">
							</div>
						</div>
					
						@endforeach
					</div>
					
				</div>
			</div>

			<div class="w-size14 p-t-30 respon5">
				<h4 class="product-detail-name m-text16 p-b-13">
					{{ $product->name }}
				</h4>

				<span >
					Bảo hành : {{ $product->warranty_time }}
				</span>
					
				<div class="p-b-45">
					<p class="s-text8 m-r-35">SKU: {{ $product->code }}</p>
					<p class="s-text8">Brand: {{ $product->brand_name }}</p>
					<p class="s-text8">Origin: {{ $product->origin }}</p>
					
					<h6 style="color: red; text-decoration: line-through; margin-bottom:1%;">Price: {{ number_format($product->price) }} VNĐ</h6>
					<h4 style=" margin-bottom:3%;">Price sale: {{ number_format($product->price -($product->price * $product->sale)/100) }} VNĐ</h4>
					<h6 style="color: green">Tiết kiệm : {{ $product->sale }} %</h6>
				</div>
				
				
				<!--  -->
			<div class="p-t-33 p-b-60">
				
					

					<div style="text-align: left !important;" >
						<form id="form-add_to_cart">
						<h5>Số lượng còn lại: <span id="quantity_remaining" style="margin :3%;">{{ $product->quantity }}</span> sản phẩm</h5>
						<div class="w-size16 flex-m flex-w">
							
							<div class="flex-w bo5 of-hidden m-r-22 m-t-10 m-b-10">
								<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
									<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
								</button>
								<input type="hidden" readonly id="product_id" name="product_id" value="{{ $product->id }}">
								<input class="size8 m-text18 t-center num-product" type="number" name="quantity_buy" value="1">

								<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
									<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
								</button>
							</div>
							<div style="clear: both;"></div>
							<div class="btn-addcart-product-detail size9 trans-0-4 m-t-10 m-b-10">
								<!-- Button -->

								<button name="submit" class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
									Add to Cart
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>

				

				<!--  -->
				
				
			</div>
		</div>
	</div>
	<div class="container bgwhite p-t-35 p-b-80">
		<div class="flex-w flex-sb">
			<div  style="width: 70%; margin: auto;">
				@foreach($product->reviews as $reviews)
				<h3 style=" margin:5% auto 5%;">{{ $reviews->description }}</h3>
				<h6 style="margin-bottom: 5%;">{{ $reviews->content }}</h6>
				<div style="margin-bottom: 5%;">
					<img style="width: 100%;" src="/storage/{{ $reviews->thumbnail }}">
					
				</div>
				@endforeach
			</div>
			
		</div>
	</div>

	<section class="newproduct bgwhite p-t-45 p-b-105">
		<div class="container">
			<div class="sec-title p-b-60">
				<h3 class="m-text5 t-center">
					Featured Products
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
				@foreach($product_categories as $product)
				@if($product->thumbnail!=null)
					<div class="item-slick2 p-l-15 p-r-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelnew">
								<img src="/storage/{{ $product->thumbnail->thumbnail }}" alt="{{ $product->thumbnail->thumbnail }}">

								<div class="block2-overlay trans-0-4">
									<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
										<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
										<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
									</a>

									<div class="block2-btn-addcart w-size1 trans-0-4">
										<!-- Button -->
										<a href="/product/search/{{ $product->slug }}" class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text1 trans-0-4">
											Detail
										</a>
									</div>
								</div>
							</div>

							<div style="text-align: center;" class="block2-txt p-t-20">
								<a  href="javascript:;" class="block2-name dis-block s-text3 p-b-5">
									{{ $product->name }}
								</a>
								<p style="color: red; text-decoration: line-through; margin-bottom:1%;">{{ number_format($product->price) }} VNĐ</p>
								<p style="color: green; margin-bottom:3%;">{{ number_format($product->price -($product->price * $product->sale)/100) }} VNĐ</p>
							</div>
						</div>
					</div>
				@endif
				@endforeach
				</div>
			</div>

		</div>
	</section>
	
	
@endsection
@section('js')
	<script type="text/javascript" src="{{ asset('/js/mainDetailProduct.js') }}"></script>
@endsection