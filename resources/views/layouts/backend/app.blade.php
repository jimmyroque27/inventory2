<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->

	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield('title') - {{ config('holdings.OWNER.OWNER_NAME') }}</title>

	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="{{ asset('assets/backend/plugins/font-awesome/css/font-awesome.min.css') }}">
	<!-- IonIcons -->
	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('assets/backend/css/adminlte.min.css') }}">
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

	<link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

	<link rel="icon" href="{{ asset('assets/frontend/img/favicon.ico') }}" type="image/x-icon" />

	<style>

	/* width */
	.nav-link.active{
	  background-color: rgb(255 255 255 / 25%) !important;
	}
	.nav-treeview > .nav-item {
		padding-left: 5px !important;

	}
	.nav-sidebar > .nav-header{
		height:5px !important;
	}
	.nav-header > hr {
	  margin-top: -1rem;
	  margin-bottom: 0rem;

	  border-top: 1px solid rgba(255, 255, 255, 0.30);
	}
	.navbar{
		padding-top:10px !important;
	  padding-bottom:5px !important;
		max-height: 50px !important;
	}
	.navbar-expand-md .navbar-nav .nav-link {
		padding-left: 0px;
	}
	.actionsCol >.btn{
		font-size: .7rem !important;
		width: 22px;
		height: 22px;
		padding: 2px;

	}
	.brand-link{
		height: 50px !important;
	}
	.wrapper{
		margin-top: 40px !important;
		margin-bottom: 28px !important;
	}
	.nav-fixed-top {
		z-index: 2;
	  top:0px;
		width: 100% !important;
    position: fixed !important;

	}
	.nav-treeview > .nav-item > .nav-link{

		color: #ffbb00 !important;
	}
	.text-right{
		text-align: right !important;
	}
	.text-left{
		text-align: left !important;
	}
	.text-center{
		text-align: center !important;
	}
	::-webkit-scrollbar  {
	  width: 2px;
	}

	/* Track */
	::-webkit-scrollbar-track {
	  box-shadow: inset 0 0 5px grey;
	  border-radius: 5px;
	}

	/* Handle */
	::-webkit-scrollbar-thumb {
	  background: #343a40;
	  border-radius: 5px;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
	  background: #ccc;
	}
	.btn.btn-xs{
	  font-size: .7rem !important;
	  width: 25px;
	  height: 25px;
	  padding: 4px;
	}
	</style>
	@stack('css')

</head>

<body class="hold-transition sidebar-mini d-flex flex-column min-vh-100">
<div class="wrapper">
	<!-- Navbar -->
	@include('layouts.backend.partial.navbar')
	<!-- /.navbar -->

	<!-- Main Sidebar Container -->
	@include('layouts.backend.partial.sidebar')

	<!-- Content Wrapper. Contains page content -->
	@yield('content')
	<!-- /.content-wrapper -->

	<!-- Main Footer -->
	@include('layouts.backend.partial.footer')

</div>
<!-- ./wrapper -->




<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('assets/backend/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/backend/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('assets/backend/js/adminlte.js') }}"></script>

<script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
{!! Toastr::message() !!}

<script>
	@if($errors->any())
	@foreach($errors->all() as $error)
	toastr.error('{{ $error }}', 'Error!!', {
		closeButton:true,
		progressBar:true,
	});
	@endforeach
	@endif
	var title = "@yield('title')";
	if (title != "Dashboard"){
		$( "body" ). addClass( 'sidebar-collapse');
		//	body.classList.add("sidebar-collapse");
	}

</script>
<script>


	var elem = document.documentElement;
	function openFullscreen() {
	  if (elem.requestFullscreen) {
	    elem.requestFullscreen();
	  } else if (elem.webkitRequestFullscreen) { /* Safari */
	    elem.webkitRequestFullscreen();
	  } else if (elem.msRequestFullscreen) { /* IE11 */
	    elem.msRequestFullscreen();
	  }
		$(".restore-screen").removeClass( "d-none" );
		$(".full-screen").addClass( "d-none" );
	}

	function closeFullscreen() {
	  if (document.exitFullscreen) {
	    document.exitFullscreen();
	  } else if (document.webkitExitFullscreen) { /* Safari */
	    document.webkitExitFullscreen();
	  } else if (document.msExitFullscreen) { /* IE11 */
	    document.msExitFullscreen();
	  }
		$(".full-screen").removeClass( "d-none" );
		$(".restore-screen").addClass( "d-none" );


	}
	//
	// $(document).ready(function(){
	//  //my code here
	//
	// 	openFullscreen();
	// });
	// var fs = 0;
	// addEventListener("click", function() {
	// 	 if (fs == 0){
	//      var
	//            el = document.documentElement
	//          , rfs =
	//                 el.requestFullScreen
	//              || el.webkitRequestFullScreen
	//              || el.mozRequestFullScreen
	//      ;
	//      rfs.call(el);
	// 		 $(".full-screen").addClass( "d-none" );
	// 		 $(".restore-screen").removeClass( "d-none" );
	// 	}
	// 	fs = 1;
 // });

 function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
</script>


@stack('js')

</body>

<style>
	body{font-size: 12px !important};
	table.dataTable{
	  border-collapse: collapse !important;
		border-spacing: 0 !important;
	}
	table.dataTable {
		font-size: 12px;
		border-radius: 2px 2px 0px 0px;
	}
	table.dataTable th
	{
	 	padding: 10px !important;
		border-top: 0 !important;
		border-bottom: 0 !important;
	}
	table.dataTable td
	{
	 	padding: 5px !important;


	}
.nav-title{
	padding-left: 0px !important;
}
.nav-link{
	padding-right: 5px !important;
}
.main-footer{
		padding: 5px 5px 5px 10px !important;
		z-index: 1 !important;
}
.footer-btn{
	padding: 0px 10px 0px 10px !important;
	max-height: 30px;
}
</style>
<style>
 	.main-sidebar  {

	    overflow-x: hidden !important;
			margin-bottom: 0px !important;
			padding-bottom: 0px !important;
	}

</style>
</html>
