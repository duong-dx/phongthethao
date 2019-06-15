<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
     dd(Cart::instance('admin')->content());
 return view('shop.home');
});

Route::get('/categories/{slug}','ProductController@productCategory');
Route::prefix('product')->group(function(){
     // saleonline controller
      Route::resource('saleonline','SaleOnlineController');
      Route::delete('delete','SaleOnlineController@delete');
      Route::post('orderonline','OrderOnlineController@store');

     Route::get('{slug}','ProductController@detailProductSlug');
     
     // lấy ra các chi tiết sản phẩm có slug và memory truyền vào
     Route::get('{slug}/{memory}/{color_id}','DetailProductController@getDP');
     Route::get('{slug}/{memory}','ProductController@getDetailProductSlugMemory');
     Route::get('','ProductController@productList');
     
     Route::get('/test', function () {
      return view('test');
     });
});

// Route::group(['prefix'=>'admin','middleware' => ['role:admin']], function(){
Route::prefix('admin')->group(function(){
     Auth::routes();

     Route::middleware('auth')->group(function(){
          // PROFILE USER
          Route::get('/profile', function () {
      
           return view('user.profile');
          });

          Route::resource('images','ImageController');

          Route::group(['middleware' => ['role:admin']], function() {
               /**
                    * Tác dụng : sủ lý  permissions
                    */
               Route::get('/getPermissions','PermissionController@getPermissions')->name('getPermissions');
               Route::resource('permissions','PermissionController');

               /**
                    * Tác dụng : sủ lý  roles
                    */
               Route::get('/getRoles','RoleController@getRoles')->name('getRoles');
               // lấy tất cả các permission tỏng PermissionController
               Route::get('/showPermissions/{id}','PermissionController@showPermissions')->name('showPermissions');
               Route::get('/getPermissionRole/{id}','RoleController@getPermissionRole')->name('getPermissionRole');
               Route::post('/addPermissionRol','RoleController@addPermissionRol')->name('addPermissionRol');
               Route::resource('roles','RoleController');
               // admin mới được chỉnh sửa danh sách trạng thái
                 // statuses
               Route::resource('statuses','StatusController');
               Route::get('getStatuses','StatusController@getStatuses')->name('getStatuses');
          });



               /**
                    * Tác dụng : lấy thông tin và sử lý categories
                    *
                    * @param  name space
                    * @param  int   biến chuyền vào
                    * @return \Illuminate\Http\Response trả về gì
                    */
               Route::get('/getCategories',
                    ['middleware' => ['permission:show_category'], 
                    'uses'=>'CategoryController@getCategories'])->name('getCategories');
               
               Route::resource('categories','CategoryController');

               /**
                    * Tác dụng : sủ lý option 
                    */
               Route::get('/getOptions','OptionController@getOptions')->name('getOptions');
               Route::resource('options','OptionController');

               /**
                    * Tác dụng : sủ lý  option_vlaues
                    */
               Route::get('/getOptionValues/{id}','OptionValueController@getOptionValues')->name('getOptionValues');
               Route::resource('option_vlaues','OptionValueController');

               /**
                    * Tác dụng : sủ lý  colors
                    */
               Route::get('/getColors',['middleware'=>['permission:show_color'],'uses'=>'ColorController@getColors'])->name('getColors');
               Route::resource('colors','ColorController');
               /**
                    * Tác dụng : sủ lý  memories
                    */
               Route::get('/getMemories',['middleware'=>['permission:show_memory'],'uses'=>'MemoryController@getMemories'])->name('getMemories');
               Route::resource('memories','MemoryController');

               /**
                    * Tác dụng : sủ lý  brands
                    */
               Route::get('/getBrands',['middleware'=>['permission:show_brand'],'uses'=>'BrandController@getBrands'])->name('getBrands');
               Route::resource('brands','BrandController');


               /**
                    * Tác dụng : sủ lý  users
                    */
                 //get role 
              
               Route::get('/getUsers',['middleware'=>['permission:show_user'],'uses'=>'UserController@getUsers'])->name('getUsers');
               Route::get('/getRoleUser/{id}',
               ['middleware'=>['permission:edit_role_user'],'uses'=>'UserController@getRoleUser'])->name('getRoleUser');
               Route::post('/addRoleUser',['middleware'=>['permission:edit_role_user'],'uses'=>'UserController@addRoleUser'])->name('addRoleUser');
               Route::resource('users','UserController');


               /**
                    * Tác dụng : sủ lý  customers
                    */

               Route::get('/getCustomers',['middleware'=>['permission:show_customer'],'uses'=>'CustomerController@getCustomers'])->name('getCustomers');
               Route::resource('customers','CustomerController');


               /**
                    * Tác dụng : sủ lý  products
                    */
               Route::get('/getProducts',['middleware'=>['permission:show_product'],'uses'=>'ProductController@getProducts'])->name('getProducts');
               Route::resource('products','ProductController');
               Route::post('/addImages',['middleware'=>['permission:update_product'],'uses'=>'ProductController@addImages']);

               /**
                    * Tác dụng : sủ lý  branches
                    */
               Route::get('/getBranches','BranchController@getBranches')->name('getBranches');
               Route::get('/getProductInBranch/{id}',['middleware'=>['permission:show_branch'],'uses'=>'BranchController@getProductInBranch'])->name('getProductInBranch');

               Route::resource('branches','BranchController');
               

               /**
                    * Tác dụng : sủ lý  detail_products
                    */
               Route::get('/getDetailProducts/{id}',['middleware'=>['permission:show_detail_product'],'uses'=>'DetailProductController@getDetailProducts'])->name('getDetailProducts');
               Route::resource('detail_products','DetailProductController');

                /**
                    * Tác dụng : sủ lý  review
                    */
               Route::get('/getReviews/{id}',['middleware'=>['permission:show_review'],'uses'=>'ReviewController@getReviews'])->name('getReviews');
               Route::resource('reviews','ReviewController');
               



          Route::group(['middleware' => ['permission:salesman']], function() {        
               /**
                    * Tác dụng :sale route
                    *
                    */
               Route::get('/getDetailProductSale/{id}','DetailProductController@getDetailProductSale')->name('getDetailProductSale');
               Route::get('/getProductSale','ProductController@getProductSale')->name('getProductSale');

               Route::resource('sales','SaleController');
               Route::get('/getCart','SaleController@getCart');
               Route::delete('/delete','SaleController@delete');
               Route::get('/subtotal','SaleController@getSubtotalCart');

               // orders
               Route::resource('orders','OrderController');
               Route::get('getOrders','OrderController@getOrders')->name('getOrders');
               Route::get('getBill/{id}','OrderController@getBill')->name('getBill');

             
               //  return datatables detail_orders
               Route::get('getDetailOrder/{id}','DetailOrderController@getDetailOrder')->name('getDetailOrder');

          });

          // thống kê sơ bộ 
          Route::get('statistical','StatisticalController@index');
          
     });
});


/**
     * Tác dụng : customers
     *
     */
     

Route::prefix('customer')->group(function(){
     Route::get('login', 'CustomerAuth\LoginController@showLoginForm');
     Route::post('login', 'CustomerAuth\LoginController@login');
     Route::post('logout', 'CustomerAuth\LoginController@logout');
     Route::get('register', 'CustomerAuth\RegisterController@showRegistrationForm');
     Route::post('register', 'CustomerAuth\RegisterController@register');
     Route::post('reset_password', 'CustomerAuth\ResetController@reset');

     // route login mạng xã hội 
     Route::get('login/facebook', 'CustomerAuth\SocialiteController@redirectToProvider');
     Route::get('login/facebook/callback', 'CustomerAuth\SocialiteController@handleProviderCallback');


// đăng nhập bằng google
      
     // Route::get('login/google', 'CustomerAuth\SocialiteController@redirectToProviderGoogle');
     // Route::get('login/google/callback', 'CustomerAuth\SocialiteController@handleProviderCallbackGoogle');


     Route::middleware('customer.auth')->group(function(){
               Route::get('/test', function () {
                    return view('customer_auth.test');
          });
               Route::get('profile/{id}','CustomerController@profile')->name('profile');

               Route::put('customers/{id}','CustomerController@updateProfile');
     });
});