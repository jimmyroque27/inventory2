<div class="nav-fixed-top">
<nav class="main-header navbar  navbar-expand-md bg-white navbar-light border-bottom ">
	<!-- Left navbar links -->
	<ul class="navbar-nav">
		<li class="nav-item">
			<a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
		</li>

		<li class="nav-item d-none d-sm-inline-block">
			<a href="@yield('mainUrl')" class="nav-link">@yield('maintitle') | </a
		</li>
		<li class="nav-item d-none d-sm-inline-block  ">
			<a href="#" class="nav-link"> @yield('title') </a>
		</li>

		<!--
		<li class="nav-item d-none d-sm-inline-block">
			<a href="index3.html" class="nav-link">Home</a>
		</li>
		<li class="nav-item d-none d-sm-inline-block">
			<a href="#" class="nav-link">Contact</a>
		</li> -->
		<title>{{ config('app.name', 'Laravel') }}</title>

	</ul>

	<!-- SEARCH FORM -->
	<!-- <form class="form-inline ml-3">
		<div class="input-group input-group-sm">
			<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
			<div class="input-group-append">
				<button class="btn btn-navbar" type="submit">
					<i class="fa fa-search"></i>
				</button>
			</div>
		</div>
	</form> -->

	<!-- Right navbar links -->
	<ul class="navbar-nav ml-auto">
		<li class="nav-item dropdown">
			<a class="nav-link" href="{{route('admin.events')}}"  >

			 <i class="fa fa-calendar p-2  rounded bg-warning"></i>
			</a>

		</li>
		<!-- Profile Dropdown Menu -->
		<li class="nav-item dropdown ">
			<a class="nav-link" data-toggle="dropdown" href="#">
				<i class="fa fa-th-large p-2 rounded bg-info"></i>

			</a>
			<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
				<span class="dropdown-item dropdown-header">Profile Menu</span>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fa fa-envelope mr-2"></i> Profile
				</a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item">
					<i class="fa fa-users mr-2"></i> Settings
				</a>
				<div class="dropdown-divider"></div>
				<a class="dropdown-item" href="{{ route('logout') }}"
				    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
					<i class="fa fa-file mr-2"></i> Logout
				</a>
				<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
					@csrf
				</form>

			</div>
		</li>

	</ul>
</nav>
</div>
