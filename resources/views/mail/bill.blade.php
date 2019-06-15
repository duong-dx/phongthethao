<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hóa đơn</title>
</head>
<body>
	<div  style="margin: auto;  width: 90%;">
							<div style="text-align: center;">
								
								<h3 style="margin: 2% auto 2%;">Hóa Đơn Bán Hàng</h3>
							</div>
							<p >Mã hóa đơn:<span style="margin: 2%;">{{ $order->code }}</span></p>
							<p>Bạn có thể truy câp : phamtuananh.com để kiểm tra trạng thái hóa đơn</p>
							<p >Tên khách hàng:<span style="margin: 2%;"id="customer_name">{{ $order->customer_name }}</span></p>
							<p >Số điện thoại:<span style="margin: 2%;"id="customer_mobile">{{ $order->customer_mobile }}</span></p>
							<p >Địa chỉ :<span style="margin: 2%;"id="customer_address">{{ $order->customer_address }}</span></p>
							<p >Email :<span style="margin: 2%;"id="customer_email">{{ $order->customer_email }}</span></p>
							
							
							<div>
								<table class="table" >
									<thead >
										
											<th>Product name</th>
											<th>Price Sale</th>
											<th>Quantity</th>
											<th>Total</th>
										
									</thead>
									<tbody id="tbody-bill-table">
										@foreach($carts as $cart)
											<tr>
												<td>{{ $cart->name }}</td>
												<td>{{ number_format($cart->price) }}</td>
												<td>{{ $cart->qty }}</td>
												<td>{{ number_format($cart->qty*$cart->price) }}
												</td>
												
											</tr>
										@endforeach
									</tbody>
								</table>

							</div>
							<h4>Tổng đơn hàng :<span style="margin: 1%;" >{{ $total_cart }}</span>VNĐ</h4>
							<div style="text-align: right;margin-right: 10%;">
								{{ date('F d, Y', strtotime($order->created_at)) }}
							</div>
							
						</div>
</body>
</html>