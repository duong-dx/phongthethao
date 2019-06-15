@extends('layouts.master')
@section('css')
<style type="text/css">
	.dropzone {
		border: 2px dashed #0087F7;
		border-radius: 5px;
		background: white;
		width: 80%; 
		margin:2% auto;
		

	}
</style>
@endsection
@section('content')

<div style="font-size: 15px !important;" class="container">
	@if(Auth::user()->can('add_product'))
	<a style="margin: 5% 0% 2% 0%; " href="javascript:;" class="btn btn-dark btn-add">
		Add product
	</a>
	@endif
	<h4 style="margin: 1% 0% 2% 0%; ">Product</h4>
	
	<div class="table-responsive">
		<table style="text-align: center;" class="table table-bordered" id="products-table">
			<thead >
				<tr>
					<th>Name</th>
					<th>Category name</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Action</th>
				</tr>
			</thead>
		</table>
		<div class="clear"></div>
	</div>
	
	{{-- modal add  --}}
	@if(Auth::user()->can('add_product'))
	<div class="modal fade" id="modal-add">
		<div style="width: 80%;" class="modal-dialog">
			<div class="modal-content">


				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Add Product</h4>

				</div>
				
				<form action="" id="form-add" method="post" role="form" enctype="multipart/form-data">
					@csrf
					<div style="margin:auto; " class="modal-body">
						<div style="float: left; width:49%; margin:auto; ">
							<h4 style="margin-bottom: 5%;">Thông tin :</h4>
							<div class="form-group">
								<label for="">* Name</label>
								<input type="text" class="form-control" id="name_add"  name ="name" placeholder="Name">
								<span id="span_name_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Slug</label>
								<input type="text" class="form-control" id="slug_add"  name ="slug" placeholder="Slug">
								<span id="span_slug_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Price</label>
								<input type="number" class="form-control" id="price_add"  name ="price" placeholder="Price">
								<span id="span_price_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Sale %</label>
								<input type="number" class="form-control" id="sale_add"  name ="sale" placeholder="Sale %">
								<span id="span_sale_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Quantity</label>
								<input type="number" class="form-control" id="quantity_add"  name ="quantity" placeholder="Quantity">
								<span id="span_quantity_add"></span>
							</div>
							
						</div>
						<div style="float: left; width:49%; margin-left: 2%;">
							<h4 style="margin-bottom: 5%;  ">Phân loại :</h4>
							<div class="form-group">
								<label for="">* Branch </label>
								<select class="form-control" id="branch_id_add"  name ="branch_id">
									@foreach($branches as $branch)
									<option value="{{ $branch->id }}">{{ $branch->name }}</option>
									@endforeach
								</select>
								
								<span id="span_branch_id_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Category </label>
								
								<select class="form-control" id="category_id_add"  name ="category_id">
									@foreach($categories as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
								</select>
								
								<span id="span_category_id_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Brand </label>
								
								<select class="form-control" id="brand_id_add"  name ="brand_id">
									@foreach($brands as $brand)
									<option value="{{ $brand->id }}">{{ $brand->name }}</option>
									@endforeach
								</select>
								
								<span id="span_brand_id_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Description</label>
								<input type="text" class="form-control" id="description_add"  name ="description" placeholder="Description">
								<span id="span_description_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Content</label>
								<input type="text" class="form-control" id="content_add"  name ="content" placeholder="Content">
								<span id="span_content_add"></span>
							</div>

						</div>

					</div>
					<div class="clear"></div>
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
	@if(Auth::user()->can('update_product'))
		<div class="modal fade" id="modal-update">
			<div style="width: 80%;" class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-update" method="category" role="form">
						@csrf
						<input type="hidden" id="put" name="_method" value="put">
						<input type="hidden" readonly name="id" id="id_update">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Edit Product</h4>
						</div>
						
						<div class="modal-body">

								<div style="float: left; width:49%; margin:auto; ">
									<h4 style="margin-bottom: 5%;">Thông tin :</h4>

									<div class="form-group">
										<label for="">* Name</label>
										<input type="text" class="form-control" id="name_update"  name ="name" placeholder="Name">
									</div>
									<div class="form-group">
										<label for="">* Slug</label>
										<input type="text" class="form-control" id="slug_update"  name ="slug" placeholder="Slug">
									</div>
									<div class="form-group">
										<label for="">* Price</label>
										<input type="number" class="form-control" id="price_update"  name ="price" placeholder="Price">
									</div>
									<div class="form-group">
										<label for="">* Sale %</label>
										<input type="number" class="form-control" id="sale_update"  name ="sale" placeholder="Sale %">
									</div>
									<div class="form-group">
										<label for="">* Quantity</label>
										<input type="number" class="form-control" id="quantity_update"  name ="quantity" placeholder="Quantity">
									</div>
								</div>
								<div style="float: left; width:49%; margin-left: 2%;">
									<h4 style="margin-bottom: 5%;  ">Thông số :</h4>
									<div class="form-group">
										<label for="">* Branch </label>
										<select class="form-control" id="branch_id_update"  name ="branch_id">
											@foreach($branches as $branch)
											<option value="{{ $branch->id }}">{{ $branch->name }}</option>
											@endforeach
										</select>

									</div>
									<div class="form-group">
										<label for="">* Category </label>

										<select class="form-control" id="category_id_update"  name ="category_id">
											@foreach($categories as $category)
											<option value="{{ $category->id }}">{{ $category->name }}</option>
											@endforeach
										</select>

									</div>
									<div class="form-group">
										<label for="">* Brand </label>

										<select class="form-control" id="brand_id_update"  name ="brand_id">
											@foreach($brands as $brand)
											<option value="{{ $brand->id }}">{{ $brand->name }}</option>
											@endforeach
										</select>

									</div>
									<div class="form-group">
										<label for="">* Description</label>
										<input type="text" class="form-control" id="description_update"  name ="description" placeholder="Description">
									</div>
									<div class="form-group">
										<label for="">* Content</label>
										<input type="text" class="form-control" id="content_update"  name ="content" placeholder="Content">
									</div>
									
								</div>
						</div>
						<div class="clear"></div>
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
{{-- modal show  --}}
	@if(Auth::user()->can('show_product'))
		<div class="modal fade" id="modal-show">
		<div style="width:80%;" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom: 0px;">
					
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4   >Thông tin sản phẩm :</h4>
					

				</div>
				<div style="margin:auto; width:60%;" id="images-div">
					
				</div>
				<div style="font-size: 15px; margin:  auto; text-align: left;">
							<table  style="text-align: left;margin:auto; width:80%; " class="table">

								
								
								<tr>
									<td>Name :</td>
									<td><p id="product_name"></p></td>
									<td>Chi nhánh :</td>
				                  <td><p id="product_branch"></p></td>
								</tr>
				                
				                <tr>
				                  <td>Slug :</td>
				                  <td><p id="product_slug"></p></td>
				                   <td>User name :</td>
				                  <td><p id="product_user_id"></p></td>
				                </tr>
				               
								<tr>
									<td>Category name :</td>
									<td><p id="product_category_id"></p></td>
									<td>Brand name :</td>
									<td><p id="product_brand_id"></p></td>
								</tr>
								<tr>
									<td>Price :</td>
									<td><p id="product_price"></p></td>
									<td>Quantity :</td>
									<td><p id="product_quantity"></p></td>
								</tr>
								<tr>
									<td>Sale :</td>
									<td><p id="product_sale"></p></td>
									<td>Description :</td>
									<td><p id="product_description"></p></td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
					</div>
			</div>
		</div>
		</div>
	@endif
{{-- modal images --}}
	@if(Auth::user()->can('update_product'))
		<div class="modal fade" id="modal-images">
		<div style="width:80%;" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom: 0px;">
					
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4   >Ảnh sản phẩm :</h4>
					

				</div>
				<div style="margin-bottom:10%;" style="margin:auto; width:60%; text-align: center;" id="list_images">
					
				</div>
				<div class="clear"></div>

				<div style="text-align: center; margin: 5%;">
					<h5 >Thêm ảnh sản phẩm :</h5>
							<form action="/admin/addImages" class="dropzone" id="myDropzone">
						      @csrf
						      <input type="hidden" readonly name="product_id" id="product_id_add_images">
						      <div class="fallback">
						        <input name="file" type="file" multiple />
						      </div>
						    </form>
							
						</div>
						<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit"  id="save_images" class="btn btn-primary">Save</button>
					</div>
			</div>
		</div>
		</div>
	@endif


{{-- modal REVIEW --}}
@if(Auth::user()->can('show_review'))
	<div class="modal fade" id="modal-reviews">
		<div style="width:80%;" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="padding-bottom: 0px;">
					
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4  >Chi tiết sản phẩm :</h4>
					

				</div>
				@if(Auth::user()->can('crud_review'))
				<a style="margin-left: 5%;margin-top: 3%; " id="add_review" href="javascript:;" class="btn btn-success">
						Add Review
					</a>
				@endif
				<h5 style="margin-left: 5%;">Review</h5>
				<div class="modal-body">
					
					<div style="margin: auto; width: 90%;">
						<table class="table" id="reviews-table">
							<thead >
								<tr>
									<th>Id</th>
									<th>Product name</th>
									<th>Image</th>
									<th>Action</th>
								</tr>
							</thead>
						</table>
					</div>

				</div>
				<div class="clear"></div>
				<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						
				</div>
			</div>
		</div>
	</div>
@endif

	{{-- modal add reviews --}}
	@if(Auth::user()->can('crud_review'))
		<div class="modal fade"  id="modal-add_reviews">
			<div style="width: 70%;" class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-add_reviews"  role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Add Review</h4>
						</div>
							<div style="  width: 45%; float: left; ">
								<div style="width: 50%; margin:5% auto 5%;">
								<img style="width: 100%; height: 100%;" src="/storage/default_image.png" class="avatar img-circle img-thumbnail" alt="avatar">
								<span id="span_thumbnail_add"></span>
								</div>
									<div class="clear"></div>	
								<input style="margin:5% auto 5%;" type="file"  class="text-center center-block file-upload" name ="thumbnail" id="thumbnail_add"  placeholder="Thumbnail">
								<input type="hidden" readonly id="product_id_add_reviews" name="product_id">
								
							</div>
							
						
							
						<div style="float: left; width: 50%; margin-top: 1%;" class="modal-body">
							
							<div class="form-group">
								<label for="">* Description</label>
								<input type="text" class="form-control description" id="description_review_add"  name ="description" placeholder="Description">
								<span id="span_description_add"></span>
							</div>
							<div class="form-group">
								<label for="">* Content</label>
								<input type="text" class="form-control" id="content_review_add"  name ="content" placeholder="Content">
								<span id="span_content_add"></span>
							</div>
						</div>
						<div class="clear"></div>
						<div class="modal-footer">
							<button type="button" id="close-review-add" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit"  class="btn btn-primary">Add</button>
						</div>
					</form>
				
			</div>
		</div>
		</div>
	@endif

		{{-- modal show reviews --}}
		@if(Auth::user()->can('show_review'))
		<div class="modal fade"  id="modal-show_reviews">
			<div style="width: 70%;" class="modal-dialog">
				<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Show Review</h4>
						</div>
							
						
							
						<div style="width: 90%; margin:auto;" class="modal-body">	
							<div style="width: 43%; float: left; margin:3% ;">
								<img id="thumbnail_show_review" style="width: 100%; height: 100%;">
							</div>
							<div style="width: 43%;  float: left; margin:3%;">
								<h4 >Tên sản phẩm: <span id="product_name_review"></span></h4>
							
								<h5 id="description_show_review"></h5>
								
								<p id="content_show_review"></p>
							</div>
							
							
						</div>
						<div class="clear"></div>
						<div class="modal-footer">
							<button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
							
						</div>
					
				
			</div>
		</div>
		</div>
		@endif

{{-- modal edit reviews --}}
@if(Auth::user()->can('crud_review'))
		<div class="modal fade"  id="modal-update_reviews">
			<div style="width: 70%;" class="modal-dialog">
				<div class="modal-content">

					<form action="" id="form-update_review"  role="form" enctype="multipart/form-data">
						@csrf
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Update Review</h4>
						</div>
							<div style="  width: 45%; float: left; ">
								<div style="width: 50%; margin:5% auto 5%;">
								<img style="width: 100%; height: 100%;" id="image_review_update" class="avatar img-circle img-thumbnail" alt="avatar">
								<span id="span_thumbnail_update"></span>
								</div>
									<div class="clear"></div>	
								<input style="margin:5% auto 5%;" type="file"  class="text-center center-block file-upload" name ="thumbnail" id="thumbnail_update"  placeholder="Thumbnail">
								<input type="hidden" readonly id="product_id_update_reviews" name="product_id">
								<input type="hidden" name="_method" id="put_update" value="put">
								<input type="hidden" name="id" id="review_id">
								
							</div>
							
						
							
						<div style="float: left; width: 50%; margin-top: 1%;" class="modal-body">
							
							<div class="form-group">
								<label for="">* Description</label>
								<input type="text" class="form-control description" id="description_review_update"  name ="description" placeholder="Description">
								<span id="span_description_update"></span>
							</div>
							<div class="form-group">
								<label for="">* Content</label>
								<input type="text" class="form-control" id="content_review_update"  name ="content" placeholder="Content">
								<span id="span_content_update"></span>
							</div>
						</div>
						<div class="clear"></div>
						<div class="modal-footer">
							<button type="button" id="close-review-update" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit"  class="btn btn-primary">Save</button>
						</div>
					</form>
				
			</div>
		</div>
		</div>
		@endif
@endsection
@section('js')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script> --}}
  {{-- <script>tinymce.init({ selector:'.description' });</script> --}}
  

<script type="text/javascript" src="/js/mainProduct.js"></script>
{{-- <script>tinymce.init({ selector:'#description_add' });</script> --}}

@endsection