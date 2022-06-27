<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	@section('title', 'Innovative Technology Solutions')
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title') - {{ config('app.name', '') }}</title>

	 <link rel="icon" href="{{ asset('assets/frontend/img/favicon.ico') }}" type="image/x-icon" />
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="{{ asset('assets/backend/plugins/font-awesome/css/font-awesome.min.css') }}">
	<!-- IonIcons -->
	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

	@stack('css')

	<style>
		body {
		  margin: 0;
		  font-family: Arial, Helvetica, sans-serif;
		}

		.dropdown-menu{
			background: rgba(255, 255, 255, 0.8) !important;
		}
		.dropdown-menu a:hover{
			background: rgba(0, 0, 0, 0.8) !important;
			color: white !important;
		}

		.container-footer{
			padding-left: 0px !important;
			padding-right:  0px !important;
		}

   /* Make the image fully responsive */
   .carousel-inner img {
     width: 100%;
     height: 100%;
   }
	 .wrapper{
		 display: block;
		 padding-top:2px;
		 background: #ccc;
		 padding-bottom:2px;
		 box-shadow: 5px;
		 margin-top: 50px;
		 overflow-x: hidden;
	 }


	 .navbar-inverse{
		 border-radius: 0px !important;
		 border: 0px !important;
		 margin-bottom: 0px !important;
		 background: #111;
		 font-family: Arial, Helvetica, sans-serif;
		 font-size:12px !important;
	 }
	 .caption-dark{
	 	color : #222222 !important;
	 }
	 .caption-blue{
	 	color : #0c183d !important;
	 }
	 .caption-orange{
	 	color : orange !important;

	 }
	 .caption-bg-light{
	 	background: rgba(255, 255, 255, 0.6) !important;;

	 	border-radius: 5px;
	 }
	 .caption-bg-dark{
	 	background: rgba(0, 0, 0, 0.6) !important;;

	 	border-radius: 5px;
	 }

	 .footer-bs {
		  background-color: #3c3d41;
			padding: 60px 40px;
			color: rgba(255,255,255,1.00);
			margin-bottom: 20px;
			border-bottom-right-radius: 6px;
			border-top-left-radius: 0px;
			border-bottom-left-radius: 6px;
		}
		.footer-bs .footer-brand, .footer-bs .footer-nav, .footer-bs .footer-social, .footer-bs .footer-ns { padding:10px 25px; }
		.footer-bs .footer-nav, .footer-bs .footer-social, .footer-bs .footer-ns { border-color: transparent; }
		.footer-bs .footer-brand h2 { margin:0px 0px 10px; }
		.footer-bs .footer-brand p { font-size:12px; color:rgba(255,255,255,0.70); }

		.footer-bs .footer-nav ul.pages { list-style:none; padding:0px; }
		.footer-bs .footer-nav ul.pages li { padding:5px 0px;}
		.footer-bs .footer-nav ul.pages a { color:rgba(255,255,255,1.00); font-weight:bold; text-transform:uppercase; }
		.footer-bs .footer-nav ul.pages a:hover { color:rgba(255,255,255,0.80); text-decoration:none; }
		.footer-bs .footer-nav h4 {
			font-size: 11px;
			text-transform: uppercase;
			letter-spacing: 3px;
			margin-bottom:10px;
		}

		.footer-bs .footer-nav ul.list { list-style:none; padding:0px; }
		.footer-bs .footer-nav ul.list li { padding:5px 0px;}
		.footer-bs .footer-nav ul.list a { color:rgba(255,255,255,0.80); }
		.footer-bs .footer-nav ul.list a:hover { color:rgba(255,255,255,0.60); text-decoration:none; }

		.footer-bs .footer-social ul { list-style:none; padding:0px; }
		.footer-bs .footer-social h4 {
			font-size: 11px;
			text-transform: uppercase;
			letter-spacing: 3px;
		}
		.footer-bs .footer-social li { padding:5px 4px;}
		.footer-bs .footer-social a { color:rgba(255,255,255,1.00);}
		.footer-bs .footer-social a:hover { color:rgba(255,255,255,0.80); text-decoration:none; }

		.footer-bs .footer-ns h4 {
			font-size: 11px;
			text-transform: uppercase;
			letter-spacing: 3px;
			margin-bottom:10px;
		}
		.footer-bs .footer-ns p { font-size:12px; color:rgba(255,255,255,0.70); }

		@media (min-width: 768px) {
			.footer-bs .footer-nav, .footer-bs .footer-social, .footer-bs .footer-ns { border-left:solid 1px rgba(255,255,255,0.10); }

		}
	</style>

  <style>


    /* Full-width input fields */
    input[type=text], input[type=password] {
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    /* Set a style for all buttons */
    button {
      background-color: #04AA6D;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      opacity: 0.8;
    }

    /* Extra styles for the cancel button */
    .cancelbtn {
      width: auto;
      padding: 10px 18px;
      background-color: #f44336;
    }

    /* Center the image and position the close button */
    .imgcontainer {
      text-align: center;
      margin: 24px 0 12px 0;
      position: relative;
    }

    img.avatar {
      width: 20%;
      border-radius: 50%;
    }

    .container {
      /* padding: 16px; */
    }

    span.psw {
      float: right;
      padding-top: 16px;
    }

    /* The Modal (background) */
    .modal {
      display: none; /* Hidden by default */
      position: fixed; /* Stay in place */
      z-index: 1999; /* Sit on top */
      left: 0;
      top: 0;
      width: 100%; /* Full width */
      height: 100%; /* Full height */
      overflow: auto; /* Enable scroll if needed */
      background-color: rgb(0,0,0); /* Fallback color */
      background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
      padding-top: 10px;
			overflow-x: hidden;
			overflow-y: hidden;
    }

    /* Modal Content/Box */
    .modal-content {
      background-color: #fefefe;
      margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
      /* border: 1px solid #888; */
			padding-left: 20px;
      width: 50%; /* Could be more or less, depending on screen size */
    }

    /* The Close Button (x) */
    .close {
      position: absolute;
      right: 25px;
      top: 0;
      color: #000;
      font-size: 20px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: red;
      cursor: pointer;
    }

    /* Add Zoom Animation */
    .animate {
      -webkit-animation: animatezoom 0.6s;
      animation: animatezoom 0.6s
    }

    @-webkit-keyframes animatezoom {
      from {-webkit-transform: scale(0)}
      to {-webkit-transform: scale(1)}
    }

    @keyframes animatezoom {
      from {transform: scale(0)}
      to {transform: scale(1)}
    }

    /* Change styles for span and cancel button on extra small screens */
    @media screen and (max-width: 300px) {
      span.psw {
         display: block;
         float: none;
      }
      .cancelbtn {
         width: 100%;
      }
			div.carousel-caption{
				font-size: 10px !important;

			}

    }
  @media screen and (max-width: 600px) {
		div.carousel-caption{
			font-size: 10px !important;

		}
		div.carousel-caption h3{
			font-size: 10px !important;

		}
		.wrapper{
			margin-top: 100px !important;
		}
	}
  </style>

</head>

<body class="hold-transition">

		<header class="primary">

				 @include('layouts.frontend.partial.navbar')

	 </header>


	 	<!-- Content Wrapper. Contains page content -->
	 	@yield('content')
	 	<!-- /.content-wrapper -->


		<div id="id01" class="modal">

		  <form class="modal-content animate"  method="POST" action="{{ route('login') }}">
				  @csrf
			    <div class="imgcontainer">
			      <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
			      <img src="{{ asset('assets/frontend/img/img_avatar2.png') }}" alt="Avatar" class="avatar">
			    </div>

			    <div class="container">

						<div class="form-group row">
								<label for="email" class="col-md-2 col-form-label text-md-right">{{ __('User Email') }}</label>

								<div class="col-md-4">
										<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

										@if ($errors->has('email'))
												<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('email') }}</strong>
												</span>
										@endif
								</div>
						</div>

						<div class="form-group row">
								<label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>

								<div class="col-md-4">
										<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="current-password">

										@if ($errors->has('password'))
												<span class="invalid-feedback" role="alert">
														<strong>{{ $errors->first('password') }}</strong>
												</span>
										@endif
								</div>
						</div>

						<div class="form-group row">
								<div class="col-md-6 offset-md-4">
										<div class="form-check">
												<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

												<label class="form-check-label" for="remember">
														{{ __('Remember Me') }}
												</label>
										</div>
								</div>
						</div>

            <div class="form-group row mb-0 float-right" >
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

            </div>




			    </div>

		  </form>


		</div>



	 @include('layouts.frontend.partial.footer')
	 <!-- <footer class="subfooter">
			 <div class="container">

			 </div>
	 </footer> -->



	<!-- ./wrapper -->

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->

	@stack('js')
	<script>
	// Get the modal
	var modal = document.getElementById('id01');

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
			if (event.target == modal) {
					modal.style.display = "none";
			}
	}
	</script>
	<script>
		$('.carousel').carousel({
		  interval: 5000
		})
	</script>
</body>


</html>
