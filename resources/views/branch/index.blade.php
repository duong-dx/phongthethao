@extends('layouts.master')
@section('content')

<div style="font-size: 15px !important;" class="container">
	@if (Auth::user()->can('crud_branch'))
	<a style="margin: 5% 0% 2% 0%; " href="javascript:;" class="btn btn-dark btn-add">
		Add Branch
	</a>
	@endif
	<h4 style="margin: 1% 0% 2% 0%; "> Branches</h4>
	<div class="table-responsive">
		<table id="branches-table" class="table table-hover">
			<thead>
				<tr>
					<th>Id</th>
					<th>Address</th>	
					<th>Mobile</th>
					<th>Action</th>
				</tr>
			</thead>
			
			</table>
			<div class="clear"></div>
		</div>
		
		{{-- modal add  --}}
		@if (Auth::user()->can('crud_branch'))
		<div class="modal fade" id="modal-add">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-add" role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Add Branch</h4>
						</div>
						
						<div class="modal-body">
							
							<div class="form-group">
								<label for="">* Name</label>
								<input type="text" class="form-control" id="name_add"  name ="name" placeholder="Name">
								<span id="span_name_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Address</label>
								<input type="text" class="form-control" id="address_add"  name ="address" placeholder="Address">
								<span id="span_address_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Mobile</label>
								<input type="number" class="form-control" id="mobile_add"  name ="mobile" placeholder="Mobile">
								<span id="span_mobile_add"></span>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit"  class="btn btn-primary">Add</button>
						</div>
					</form>
				
			</div>
		</div>
		</div>
		@endif
		@if (Auth::user()->can('crud_branch'))
		{{-- modal update  --}}
		<div class="modal fade" id="modal-update">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-update" method="category" role="form">
						@csrf
						<input type="hidden" id="put" name="_method" value="put">
						<input type="hidden" name="id" id="id_update">
							
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Edit Branch</h4>
						</div>
						
						<div class="modal-body">
							<div class="form-group">
								<label for="">* Name</label>
								<input type="text" class="form-control" id="name_update"  name ="name" placeholder="Name">
								<span id="span_name_update"></span>
							</div>
							<div class="form-group">
								<label for="">* Address</label>
								<input type="text" class="form-control" id="address_update"  name ="address" placeholder="Address">
								<span id="span_address_update"></span>
							</div>
							<div class="form-group">
								<label for="">* Mobile</label>
								<input type="number" class="form-control" id="mobile_update"  name ="mobile" placeholder="Mobile">
								<span id="span_mobile_update"></span>
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
		@endif
	</div>
	</div>
	@if (Auth::user()->can('show_branch'))
	<div class="modal fade" id="modal-list_products">
			<div style="width: 80%;" class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">List Product</h4>
						</div>
						
						<div class="modal-body">
							<table id="list_products-table" class="table table-hover">
								<thead>
									<tr>
										<th>Product name</th>
										<th>Memory</th>
										<th>Color name</th>
										<th>Price Sale</th>
										<th>Quantity</th>
									</tr>
								</thead>
								
								</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							
						</div>
					</form>
				</div>
			</div>
		</div>
		@endif


@endsection
@section('js')

<script type="text/javascript" src="/js/mainBranch.js"></script>

@endsection