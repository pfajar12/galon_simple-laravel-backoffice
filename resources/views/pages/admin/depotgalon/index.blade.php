@extends('layouts.adminlayout')

@section('title')
	Airku.id | Depot Galon
@endsection

@section('content')

	<div class="row wow fadeIn">
    	<div class="col-md-12 mb-4">
    		<div class="card">
    			<div class="card-body">
    				
    				{{-- FLASH MESSAGE --}}
                    <div class="col-md-12 mb-4">
                        <div class="flash-message">
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if(Session::has('alert-' . $msg))
                                    <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
                                @endif
                            @endforeach
                        </div>
                    </div>

                    {{-- TABS --}}
                    <div class="col-md-12 mb-5">
                        <ul class="nav nav-tabs nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Depot Galon</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Depot Galon Pendaftar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#panel3" role="tab">Depot Galon Tersuspend</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">

						{{-- TAB 1 --}}
                        <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
                            <div class="col-md-12 pull-left mt-3 table-responsive">
                                <table id="datatable-depotgalon" class="table table-hover table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Tanggal Mendaftar</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- TAB 2 --}}
                        <div class="tab-pane fade" id="panel2" role="tabpanel">
                            <div class="col-md-12 pull-left mt-3 table-responsive">
                                <table id="datatable-depotgalon-pendaftar" class="table table-hover table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Tanggal Mendaftar</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- TAB 3 --}}
                        <div class="tab-pane fade" id="panel3" role="tabpanel">
                            <div class="col-md-12 pull-left mt-3 table-responsive">
                                <table id="datatable-depotgalon-tersuspend" class="table table-hover table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
    			</div>
			</div>
		</div>
	</div>

@endsection