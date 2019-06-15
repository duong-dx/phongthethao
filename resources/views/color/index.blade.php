@extends('layouts.master')
@section('content')

<div style="font-size: 15px !important;" class="container">
	@if(Auth::user()->can('crud_color'))
	<a style="margin: 5% 0% 2% 0%; " href="javascript:;" class="btn btn-dark btn-add">
		Add Color
	</a>
	@endif
	<h4 style="margin: 1% 0% 2% 0%;">Colors</h4>
	{{-- <button class="btn btn-dark btn-add">Add category</button> --}}
	<div class="table-responsive">
		<table style="text-align: center;" class="table table-bordered" id="colors-table">
		        <thead >
		            <tr>
		                 <th>Id</th>
						 <th>Code</th>
						 <th>Name</th>
						 <th>Created at</th>
						 <th>Updated at</th>
						 <th>Action</th>
		            </tr>
		        </thead>
    	</table>
		<div class="clear"></div>
	</div>
	
	{{-- modal add  --}}
	@if(Auth::user()->can('crud_color'))
		<div class="modal fade" id="modal-add">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-add" method="post" role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Add Color</h4>
						</div>
						
						<div class="modal-body">
							
							<div class="form-group">
								<label for="">* Name</label>
								<input type="text" class="form-control" id="name_add"  name ="name" placeholder="Name">
								<span id="span_name_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Code</label>
								<input type="text" class="form-control" id="code_add"  name ="code" placeholder="Code">
								<span id="span_code_add"></span>
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
	{{-- modal update  --}}
	@if(Auth::user()->can('crud_color'))
		<div class="modal fade" id="modal-update">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-update" method="category" role="form">
						@csrf
						<input type="hidden" id="put" name="_method" value="put">
						<input type="hidden" name="id" id="id_update">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Edit Color</h4>
						</div>
						<div class="clear"></div>
						<div class="modal-body">
							
							<div class="form-group">
								<label for="">* Name</label>
								<input type="text" class="form-control" id="name_update"  name ="name" placeholder="Name">
								<span id="span_name_update"></span>
							</div>
							<div class="form-group">
								<label for="">* Code</label>
								<input type="text" class="form-control" id="code_update"  name ="code" placeholder="Code">
								<span id="span_code_update"></span>
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
	


@endsection
@section('js')

<script type="text/javascript" src="/js/mainColor.js"></script>
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection