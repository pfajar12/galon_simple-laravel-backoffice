<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/bootstrap.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/mdb.min.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/font-awesome.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/style.css') }}">
		<link rel="stylesheet" type="text/css" href="{{ asset('/css/datatables.min.css') }}">
		<script type="text/javascript" src="{{ asset('/js/jquery-3.3.1.min.js') }}"></script>
	</head>

	<style type="text/css">
		.list-group-item.active{
			background-color: #75a9ff;
			border-color: #75a9ff;
			color: #fff;
		}
	</style>

	<body class="grey lighten-3" style="color: #495057">
		<header>
			<nav class="navbar fixed-top navbar-expand-lg navbar-light scrolling-navbar" style="background: #75a9ff">
	            <div class="container-fluid">

	                <!-- Brand -->
	                <a class="navbar-brand waves-effect ml-3">
	                    <h4 class="text-white"><strong>{{ ucwords(str_replace('_', ' ', $page)) }}</strong></h4>
	                </a>

	                <!-- Collapse -->
	                <button class="navbar-toggler" type="button">
	                    <span class="navbar-toggler-icon"></span>
	                </button>
	            </div>
	        </nav>
			<div class="sidebar-fixed position-fixed text-truncate" style="overflow-y: auto; width: auto">

				<div style="margin: 10px">
	                <center>
	                	<img src="{{ asset('/files/avatar/d1.jpg') }}" class="img-fluid rounded-circle" alt=""><br>
	                	{{ Auth::user()->fullname }} <br>

	                	<a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>

	                </center>
                </div>

	            <div class="list-group list-group-flush">

					@if ($page == 'dashboard')
		                <a href="{{ route('admin.dashboard') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-pie-chart mr-3"></i>Dashboard
		                </a>
	                @else
	                	<a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-pie-chart mr-3"></i>Dashboard
		                </a>
	                @endif
	            
	            	@if ($page == 'klien')
		                <a href="{{ route('admin.klien') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-user mr-3"></i>Klien
		                </a>
	                @else
	                	<a href="{{ route('admin.klien') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-user mr-3"></i>Klien
		                </a>
	                @endif

	                @if ($page == 'depot-galon')
		                <a href="{{ route('admin.depotgalon') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-home mr-3"></i>Depot Galon
		                </a>
	                @else
	                	<a href="{{ route('admin.depotgalon') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-home mr-3"></i>Depot Galon
		                </a>
	                @endif

	                @if ($page == 'tipe-galon')
		                <a href="{{ route('admin.tipegalon') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-glass mr-3"></i>Tipe Galon
		                </a>
	                @else
	                	<a href="{{ route('admin.tipegalon') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-glass mr-3"></i>Tipe Galon
		                </a>
	                @endif

	                @if ($page == 'country')
		                <a href="{{ route('admin.dashboard') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-money mr-3"></i>Deposit
		                </a>
	                @else
	                	<a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-money mr-3"></i>Deposit
		                </a>
	                @endif

	                @if ($page == 'country')
		                <a href="{{ route('admin.dashboard') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-calendar mr-3"></i>Deposit Log
		                </a>
	                @else
	                	<a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-calendar mr-3"></i>Deposit Log
		                </a>
	                @endif

	                @if ($page == 'country')
		                <a href="{{ route('admin.dashboard') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-list mr-3"></i>List Order
		                </a>
	                @else
	                	<a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-list mr-3"></i>List Order
		                </a>
	                @endif

	                @if ($page == 'country')
		                <a href="{{ route('admin.dashboard') }}" class="list-group-item waves-effect active">
		                    <i class="fa fa-calendar mr-3"></i>Order Log
		                </a>
	                @else
	                	<a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action waves-effect">
		                    <i class="fa fa-calendar mr-3"></i>Order Log
		                </a>
	                @endif
	            </div>

	        </div>	
		</header>

		<main class="pt-5 mx-lg-5">
			<div class="container-fluid mt-5">
				@yield('content')
			</div>
		</main>

		<script type="text/javascript" src="{{ asset('/js/popper.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('/js/mdb.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('/js/datatables.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('/js/sweetalert.min.js') }}"></script>
		<script type="text/javascript">
			var serverside_klien = '{{ route('serverside-klien') }}';
			var serverside_klien_pendaftar = '{{ route('serverside-klien-pendaftar') }}';
			var serverside_klien_tersuspend = '{{ route('serverside-klien-tersuspend') }}';
			var serverside_depotgalon = '{{ route('serverside-depotgalon') }}';
			var serverside_depotgalon_pendaftar = '{{ route('serverside-depotgalon-pendaftar') }}';
			var serverside_depotgalon_tersuspend = '{{ route('serverside-depotgalon-tersuspend') }}';
			var serverside_registered_client = '{{ route('serverside-registered-client') }}';
			var serverside_registered_depotgalon = '{{ route('serverside-registered-depotgalon') }}';
		</script>
		<script src="{{ asset('/js/airku.js') }}"></script>
	</body>
</html>