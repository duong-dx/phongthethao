<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>[Pham Tuan Anh]</title>
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	

	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/loginCustomer.css') }}">
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	

	{{-- script --}}
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body>

	<div id="logreg-forms">
		<form method="POST" action="/customer/login" class="form-signin">
			 @csrf
			<h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
			<div class="social-login">
				<button data-id="/customer/login/facebook" class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign in with Facebook</span> </button>
				<button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign in with Google+</span> </button>
			</div>
			<p style="text-align:center"> OR  </p>
			<input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
				@if ($errors->has('email'))
	                <span style="color:red;" role="alert">
	                   <strong>{{ $errors->first('email') }}</strong>
	                </span>
	            @endif
			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
			 	@if ($errors->has('password'))
                    <span style="color:red;" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif

			<button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign in</button>
			<a href="#" id="forgot_pswd">Forgot password?</a>
			<hr>
			<!-- <p>Don't have an account!</p>  -->
			<button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i> Sign up New Account</button>
		</form>
		{{-- FORM RESET PASSWORD --}}
		<form id="form-reset_password" class="form-reset">
			@csrf
			<input type="text" class="form-control" name="email" placeholder="Email address" >
			<button class="btn btn-primary btn-block" type="submit">Reset Password</button>
			<a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
		</form>

		<form method="POST" action="/customer/register" class="form-signup">
			@csrf
			<div class="social-login">
				<button data-id="/customer/login/facebook" class="btn facebook-btn social-btn" type="button"><span><i class="fab fa-facebook-f"></i> Sign up with Facebook</span> </button>
			</div>
			<div class="social-login">
				<button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign up with Google+</span> </button>
			</div>

			<p style="text-align:center">OR</p>

			<input type="text" id="user-name" class="form-control" name="name" placeholder="Full name" required="" autofocus="">
			@if ($errors->has('name'))
                                    <span style="color:red;" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
               @endif
			<input type="email" id="user-email" class="form-control" name="email" placeholder="Email address" required autofocus="">
			 @if ($errors->has('email'))
                                    <span style="color:red;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
			<input type="password" id="user-pass" class="form-control" name="password" placeholder="Password" required autofocus="">
			@if ($errors->has('password'))
                                    <span style="color:red;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
            @endif
			<input type="password" id="user-repeatpass" class="form-control" name="password_confirmation" placeholder="Repeat Password" required autofocus="">

			<button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Sign Up</button>
			<a href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Back</a>
		</form>
		<br>

	</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<script type="text/javascript">
	function toggleResetPswd(e){
		e.preventDefault();
    $('#logreg-forms .form-signin').toggle() // display:block or none
    $('#logreg-forms .form-reset').toggle() // display:block or none
}

function toggleSignUp(e){
	e.preventDefault();
    $('#logreg-forms .form-signin').toggle(); // display:block or none
    $('#logreg-forms .form-signup').toggle(); // display:block or none
}

$(()=>{
    // Login Register Form
    $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
    $('#logreg-forms #cancel_reset').click(toggleResetPswd);
    $('#logreg-forms #btn-signup').click(toggleSignUp);
    $('#logreg-forms #cancel_signup').click(toggleSignUp);
})
</script>

{{-- link sang facebook --}}
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$(function(){
		$('.facebook-btn').on('click',function(){
			var url = $(this).data('id');
			window.location.href=url;

		});

		$('#form-reset_password').submit(function(e){
			e.preventDefault();
			var data = $('#form-reset_password').serialize();
			$.ajax({
				type:'post',
				url:'/customer/reset_password',
				data:data,
				success: function(reponse){
						toastr.success('Password mới đã được gửi đến email của bạn !');
				},
				error: function(jq,status,throwE){
					jQuery.each(jq.responseJSON.errors,function(key,value){
                    	toastr.error(value);
                	});
				}
				
			})
		})


	});

</script>

</body>
</html>