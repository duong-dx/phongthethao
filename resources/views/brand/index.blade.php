@extends('layouts.master')
@section('content')

<div style="font-size: 15px !important;" class="container">
	@if(Auth::user()->can('crud_brand'))
	<a style="margin: 5% 0% 2% 0%; " href="javascript:;" class="btn btn-dark btn-add">
		Add Brand
	</a>
	@endif
	<h4 style="margin: 1% 0% 2% 0%; ">Brand</h4>
	{{-- <button class="btn btn-dark btn-add">Add category</button> --}}
	<div class="table-responsive">
		<table id="brands-table" class="table table-hover">
			<thead>
				<tr>
					<th>Id</th>
					<th>Name</th>
					<th>Thumbnail</th>
					<th>Slug</th>
					<th>Origin</th>					
					<th>Action</th>
				</tr>
			</thead>
			
			</table>
			<div class="clear"></div>
		</div>
		
		{{-- modal add  --}}
		@if(Auth::user()->can('crud_brand'))
		<div class="modal fade" id="modal-add">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-add" method="category" role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Add category</h4>
						</div>
							<div style="  margin: 5% auto 5%; width: 40%; height: 25%; ">
								<img style="width: 100%; height: 100%;" src="/storage/default_image.png" class="avatar img-circle img-thumbnail" alt="avatar">
							</div>
							<div class="clear"></div>
						<div class="modal-body">
							<div class="form-group">
								<label for="">Thumbnail</label>
								<input type="file"  class="form-control text-center center-block file-upload" name ="thumbnail" id="thumbnail_add"  placeholder="Thumbnail">
								<span id="span_thumbnail_add"></span>
							</div>
							<div class="form-group">
								<label for="">Name</label>
								<input type="text" class="form-control" id="name_add"  name ="name" placeholder="Name">
								<span id="span_name_add"></span>
							</div>
							<div class="form-group">
								<label for="">Slug</label>
								<input type="text" class="form-control" id="slug_add"  name ="slug" placeholder="Slug">
								<span id="span_slug_add"></span>
							</div>
							<div class="form-group">
								<label for="">Origin</label>
								<input type="text" class="form-control" id="origin_add"  name ="origin" placeholder="Origin">
								<span id="span_origin_add"></span>
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
		@if(Auth::user()->can('crud_brand'))
		<div class="modal fade" id="modal-update">
			<div class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-update" method="category" role="form">
						@csrf
						<input type="hidden" id="put" name="_method" value="put">
						<input type="hidden" name="id" id="id_update">
							
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Edit category</h4>
						</div>
						<div style="  margin: 5% auto 5%; width: 40%; height: 30%; ">
							<img style="width: 100%; height: 100%;" src="/storage/default_image.png" id="img_thumbnail_update" class="avatar img-circle img-thumbnail" alt="avatar">
						</div>
						<div class="clear"></div>
						<div class="modal-body">
							<div class="form-group">
								<label for="">Thumbnail</label>
								<input type="file" class="form-control text-center center-block file-upload" id="thumbnail_update" name ="thumbnail" placeholder="Thumbnail">
								<span id="span_thumbnail_update"></span>
							</div>
							<div class="form-group">
								<label for="">Name</label>
								<input type="text" class="form-control" id="name_update"  name ="title" placeholder="Name">
								<span id="span_name_update"></span>
							</div>
							
							<div class="form-group">
								<label for="">Slug</label>
								<input type="text" class="form-control" id="slug_update"  name ="slug" placeholder="Slug">
								<span id="span_slug_update"></span>
							</div>
							<div class="form-group">
								<label for="">Origin</label>
								<input type="text" class="form-control" id="origin_update"  name ="origin" placeholder="Origin">
								<span id="span_origin_update"></span>
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


@endsection
@section('js')

<script type="text/javascript" src="/js/mainBrand.js"></script>

@endsection