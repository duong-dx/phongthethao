@extends('layouts.master')
@section('content')

<div style="font-size: 15px !important;" class="container">
	@if(Entrust::can('crud_category'))
		<a style="margin: 5% 0% 2% 0%; " href="javascript:;" class="btn btn-dark btn-add">
			Add category
		</a>
	@endif
	<h4 style="margin: 1% 0% 2% 0%; ">Category</h4>
	{{-- <button class="btn btn-dark btn-add">Add category</button> --}}
	<div class="table-responsive">
		<table style="text-align: center;" class="table table-bordered" id="categories-table">
		        <thead >
		            <tr>
		                <th>Id</th>
		                <th>Name</th>
		                <th>Slug</th>
		                <th>Parent id</th>
		                <th>Thumbnail</th>
		                <th>Description</th>
		                <th>Action</th>
		            </tr>
		        </thead>
    	</table>
		<div class="clear"></div>
	</div>
		{{-- Modal show chi tiết category --}}
		@if(Auth::user()->can('show_category'))
		<div class="modal fade" id="modal-show">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Show category</h4>
					</div>
					<div class="modal-body" >
						
						<div style="width:80%;font-size: 18px; margin: 3% auto 3%; text-align: left;">
							
							<table style=" text-align: center;" class="table">
								<tr>
									<td>Action</td>
									<td>Value</td>
								</tr>
								<tr>
									<td>Id :</td>
									<td><span id="category_id"></span></td>
								</tr>
								<tr>
									<td>Name :</td>
									<td><span id="category_name"></span></td>
								</tr>
								<tr>
									<td>Description :</td>
									<td><span id="category_description"></span></td>
								</tr>
								
								<tr>
									<td>Slug :</td>
									<td><span id="category_slug"></span></td>
								</tr>
								<tr>
									<td>Thumbnail :</td>
									<td><span id="category_thumbnail"></span></td>
								</tr>
								<tr>
									<td>Parent id :</td>
									<td><span id="category_parent_id"></span></td>
								</tr>
								
							</table>
							
						</div>
						

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		@endif
		{{-- modal add  --}}
		@if(Auth::user()->can('crud_category'))
			<div class="modal fade" id="modal-add">
				<div class="modal-dialog">
					<div class="modal-content">

						<form action="" id="form-add" method="category" role="form" enctype="multipart/form-data">
							@csrf
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Add category</h4>
							</div>
							
							<div class="modal-body">
								
								<div class="form-group">
									<label for="">* Name</label>
									<input type="text" class="form-control" id="name_add"  name ="name" placeholder="Name">
									<span id="span_name_add"></span>
								</div>
								<div class="form-group">
									<label for="">* Parent name</label>
									
									<input type="text" id="parent_id_add" class="form-control" name ="parent_id" placeholder="Parent id">
										
									<span id="span_parent_id_add"></span>
								</div>
								<div class="form-group">
									<label for="">* Slug</label>
									<input type="text" class="form-control"  id="slug_add"  name ="slug" placeholder="Slug">
									<span id="span_slug_add"></span>
								</div>
								<div class="form-group">
									<label for="">* Thumbnail</label>
									<input type="text"  class="form-control" name ="thumbnail" id="thumbnail_add"  placeholder="Thumbnail">
									<span id="span_thumbnail_add"></span>
								</div>
								<div class="form-group">
									<label for="">* Description</label>
									{{-- <textarea id="description_add"  name ="description" class="text form-control"></textarea> --}}
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
		@endif
		
		{{-- modal update  --}}
		@if(Auth::user()->can('crud_category'))
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
							<div class="clear"></div>
							<div class="modal-body">
								
								<div class="form-group">
									<label for="">* Name</label>
									<input type="text" class="form-control" id="name_update"  name ="name" placeholder="Name">
									<span id="span_name_update"></span>
								</div>
								<div class="form-group">
									<label for="">* Parent id</label>
									<input type="text" id="parent_id_update" class="form-control" name ="parent_id" placeholde="Parent id">
										
									<span id="span_parent_id_update"></span>
									
								</div>
								<div class="form-group">
									<label for="">* Slug</label>
									<input type="text" class="form-control" id="slug_update"  name ="slug" placeholder="Slug">
									<span id="span_slug_update"></span>
								</div>
								<div class="form-group">
									<label for="">* Thumbnail</label>
									<input type="text" class="form-control" id="thumbnail_update" name ="thumbnail" placeholder="Thumbnail">
									<span id="span_thumbnail_update"></span>
								</div>
								<div class="form-group">
									<label for="">* Description</label>
									{{-- <textarea  id="description_update"  name ="description" class="text form-control"></textarea> --}}
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
		@endif
	</div>
	</div>


@endsection
@section('js')

<script type="text/javascript" src="/js/mainCategory.js"></script>
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection