@extends('layouts.master')
@section('css')
<link rel="stylesheet" type="text/css" href="/css/cssCheckBox.css">
@endsection
@section('content')

<div style="font-size: 15px !important;" class="container">
	<a style="margin: 5% 0% 2% 0%; " href="javascript:;" class="btn btn-dark btn-add">
		Add role
	</a>
	
	<div class="table-responsive">
		<table id="roles-table" class="table table-hover">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Description</th>
					<th>Action</th>
				</tr>
			</thead>
			
		</table>
		<div class="clear"></div>
	</div>

	{{-- modal add  --}}
	<div class="modal fade" id="modal-add">
		<div class="modal-dialog">
			<div class="modal-content">

				<form action="" id="form-add" role="form" enctype="multipart/form-data">
					@csrf
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Add role</h4>
					</div>

					<div class="modal-body">

						<div class="form-group">
							<label for="">* Name</label>
							<input type="text" class="form-control" id="name_add"  name ="name" placeholder="Name">
							<span id="span_name_add"></span>
						</div>
						<div class="form-group">
							<label for="">* Display Name</label>
							<input type="text" class="form-control" id="display_name_add"  name ="display_name" placeholder="Display Name">
							<span id="span_display_name_add"></span>
						</div>
						<div class="form-group">
							<label for="">* Description</label>
							<input type="text" class="form-control" id="description_add"  name ="description" placeholder="Description">
							<span id="span_description_add"></span>
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
						<h4 class="modal-title">Edit role</h4>
					</div>

					<div class="modal-body">
						<div class="form-group">
							<label for="">* Name</label>
							<input type="text" class="form-control" id="name_update"  name ="name" placeholder="Name">
							<span id="span_name_update"></span>
						</div>
						<div class="form-group">
							<label for="">* Display Name</label>
							<input type="text" class="form-control" id="display_name_update"  name ="display_name" placeholder="Display Name">
							<span id="span_display_name_update"></span>
						</div>
						<div class="form-group">
							<label for="">* Description</label>
							<input type="text" class="form-control" id="description_update"  name ="description" placeholder="Description">
							<span id="span_description_update"></span>
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

	
</div>
</div>
{{-- modal permissions  --}}
<div class="modal fade" id="modal-permissions">
	<div style="width: 70%; font-size: 15px !important;" class="modal-dialog">
		<div class="modal-content">

			<form action="" id="form-role" method="category" role="form">
				@csrf

				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit role</h4>
				</div>
				<input type="hidden" readonly id="role_id" name="role_id">
				<div class="modal-body">
					<table style="width: 90%;" id="permissions-table" class="table table-hover">
						<thead>
							<tr>
								<th>Id</th>
								<th>Description</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($permissions as $permission)
								<tr>
									<td>{{ $permission->id }}</td>
									<td>{{ $permission->description }}</td>
									<td>
										<label class="custom-control custom-checkbox">
                                    			<input style="display:none;" id="permission{{ $permission->id }}" type="checkbox" name="permission_id"
                                    value="{{ $permission->id }}" 
                                    class="custom-control-input permissions">
                                    	<span class="custom-control-indicator"></span>
                                	</label>
                            		</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit"  class="btn btn-primary">Save</button>
				</div>
			</form>
		</div>
	</div>
</div>


@endsection
@section('js')

<script type="text/javascript" src="/js/mainRole.js"></script>

@endsection