@extends('layouts.adminlayout')

@section('title')
	Airku.id | Dashboard
@endsection

@section('content')

	<div class="row wow fadeIn">
    	
        {{-- BUTTON SCROLL TO TOP --}}
        <a href="#breadcrumb" id="btnToTop" title="Go to top">Top</a>

        {{-- BREADCRUMB --}}
        <div class="col-md-12 mb-3" id="breadcrumb">
            <div class="card">
                <div class="card-body">
                    <div class="col-md-12 mb-6">
                        <nav class="pull-right">
                            <ol class="breadcrumb" style="background: none">
                                <li class="breadcrumb-item"><a href="#klien">Klien</a></li>
                                <li class="breadcrumb-item"><a href="#depotgalon">Depot Galon</a></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        {{-- NOTIF KLIEN MENUNGGU APPROVAL --}}
        @if ($registered_client_count > 0)
            <div class="col-md-12">
                <div class="flash-message">
                    <p class="alert alert-info">
                        <font class="font-weight-bold">Ada {{ $registered_client_count }} user menunggu persetujuan untuk bergabung</font>
                        <a href="{{ route('admin.klien') }}#panel3" class="pull-right font-italic">Lihat</a>
                    </p>
                </div>
            </div>
        @endif

        {{-- NOTIF DEPOT MENUNGGU APPROVAL --}}
        @if ($registered_depot_galon_count > 0)
            <div class="col-md-12">
                <div class="flash-message">
                    <p class="alert alert-primary">
                        <font class="font-weight-bold">Ada {{ $registered_depot_galon_count }} depot galon menunggu persetujuan untuk bergabung</font>
                        <a href="{{ route('admin.klien') }}#panel3" class="pull-right font-italic">Lihat</a>
                    </p>
                </div>
            </div>
        @endif

        {{-- KLIEN DAN DEPOT KESELURUHAN --}}
        <div class="col-md-12 mb-4">
            <div class="row">

                <div class="col-sm-6 mb-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 badge-default" style="border-radius: 50px; padding: 18px 0px">
                                        <center><i class="fa fa-2x fa-user"></i></center>
                                    </div>
                                    <div class="col-md-9" style="vertical-align: middle;">
                                        <div class="row">
                                            <div class="col-md-12">{{ $approved_client }}</div>
                                            <div class="col-md-12">Klien Terdaftar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 badge-info" style="border-radius: 50px; padding: 18px 0px">
                                        <center><i class="fa fa-2x fa-user"></i></center>
                                    </div>
                                    <div class="col-md-9" style="vertical-align: middle;">
                                        <div class="row">
                                            <div class="col-md-12">{{ $today_client }}</div>
                                            <div class="col-md-12">Klien Mendaftar Hari Ini</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 badge-default" style="border-radius: 50px; padding: 18px 0px">
                                        <center><i class="fa fa-2x fa-home"></i></center>
                                    </div>
                                    <div class="col-md-9" style="vertical-align: middle;">
                                        <div class="row">
                                            <div class="col-md-12">{{ $approved_depot_galon }}</div>
                                            <div class="col-md-12">Depot Terdaftar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 mb-sm-3 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 badge-info" style="border-radius: 50px; padding: 18px 0px">
                                        <center><i class="fa fa-2x fa-home"></i></center>
                                    </div>
                                    <div class="col-md-9" style="vertical-align: middle;">
                                        <div class="row">
                                            <div class="col-md-12">{{ $today_depot_galon }}</div>
                                            <div class="col-md-12">Depot Mendaftar Hari Ini</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>


        {{-- REGISTERED USER CONTENT --}}
        <div class="col-md-12 mb-4" id="klien">
            <div class="card">
                <div class="card-body">
                    <h4 style="margin-bottom: 2%">List Klien Terdaftar</h4>
                    <table id="datatable-registered-client" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Tanggal Mendaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- REGISTERED DEPOT GALON CONTENT --}}
        <div class="col-md-12 mb-5" id="depotgalon">
            <div class="card">
                <div class="card-body">
                    <h4 style="margin-bottom: 2%">Depot Galon Terdaftar</h4>
                    <table id="datatable-registered-depot-galon" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Jumlah Deposit</th>
                                <th>Tanggal Mendaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>


    <script type="text/javascript">

        // SMOOTH SCROLLING
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // BACK TO TOP SCROLLING FUNCTION
        window.onscroll = function() {scrollFunction()};

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                document.getElementById("btnToTop").style.display = "block";
            } else {
                document.getElementById("btnToTop").style.display = "none";
            }
        }
        
    </script>

@endsection