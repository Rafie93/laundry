<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laundry 2022 : Login</title>
	
	<!-- ================= Favicon ================== -->
    <!-- Standard -->
    <link rel="shortcut icon" href="http://placehold.it/64.png/000/fff">
    <!-- Retina iPad Touch Icon-->
    <link rel="apple-touch-icon" sizes="144x144" href="http://placehold.it/144.png/000/fff">
    <!-- Retina iPhone Touch Icon-->
    <link rel="apple-touch-icon" sizes="114x114" href="http://placehold.it/114.png/000/fff">
    <!-- Standard iPad Touch Icon--> 
    <link rel="apple-touch-icon" sizes="72x72" href="http://placehold.it/72.png/000/fff">
    <!-- Standard iPhone Touch Icon--> 
    <link rel="apple-touch-icon" sizes="57x57" href="http://placehold.it/57.png/000/fff">
	
	<!-- Styles -->
    <link href="{{asset('assets/fontAwesome/css/fontawesome-all.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/lib/nixon.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
	<link href="{{asset('assets/css/lib/toastr/toastr.min.css')}}" rel="stylesheet">

        @laravelPWA

</head>

<body class="bg-primary">

	<div class="Nixon-login">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-lg-offset-3">
					<div class="login-content">
						
						<div class="login-form">
							<div class="login-logo">
								{{-- <img src="{{asset('cms/img/logo.png')}}" alt="Logo" class="img-fluid rounded-circle" height="120" /> --}}
							</div>
							<h4>Welcome Laundry</h4>
							<form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
								<div class="form-group  @error('email') has-error @enderror">
									<label>Email address</label>
									<input type="email" name="email" class="form-control" placeholder="Email" value="{{old('email')}}">
                                    @error('email')
                                                <span class="help-block" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                    @enderror
								</div>
								<div class="form-group  @error('password') has-error @enderror"">
									<label>Password</label>
									<input type="password" name="password" class="form-control" placeholder="Password" value="{{old('password')}}">
                                    @error('password')
                                        <span class="help-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
								</div>
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>  {{ __('Remember Me') }}
									</label>
									<label class="pull-right">
                                        @if (Route::has('forgot'))
                                            <a class="btn btn-link" href="{{ route('forgot') }}">
                                                {{ __('Forgot Your Password?') }}
                                            </a>
                                    @endif
									</label>
									
								</div>
								<button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Sign in</button>
								{{-- <div class="social-login-content">
									<div class="social-button">
										<button type="button" class="btn btn-primary bg-facebook btn-flat btn-addon m-b-10"><i class="ti-facebook"></i>Sign in with facebook</button>
										<button type="button" class="btn btn-primary bg-twitter btn-flat btn-addon m-t-10"><i class="ti-twitter"></i>Sign in with twitter</button>
									</div>
								</div> --}}
							
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script src="{{asset('assets/js/lib/jquery.min.js')}}"></script><!-- jquery vendor -->
<script src="{{asset('assets/js/lib/toastr/toastr.min.js')}}"></script>
<script>
		@if(Session::has('message'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
				toastr.success("{{ session('message') }}");
		@endif

		@if(Session::has('error'))
		toastr.options =
		{
			"closeButton" : true,
			"progressBar" : true
		}
				toastr.error("{{ session('error') }}");
		@endif
</script>
</body>

</html>