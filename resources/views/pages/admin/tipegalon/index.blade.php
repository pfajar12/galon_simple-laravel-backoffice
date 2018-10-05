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
                                <a class="nav-link active" data-toggle="tab" href="#panel1" role="tab">Tipe Galon</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#panel2" role="tab">Tipe Galon Tidak Aktif</a>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content">

						{{-- TAB 1 --}}
                        <div class="tab-pane fade in show active" id="panel1" role="tabpanel">
                            <div class="col-md-12 pull-left mt-3 table-responsive">
                                <table id="datatable-tipegalon" class="table table-hover table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Tipe Galon</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tipegalon_aktif as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->galon_type_name }}</td>
                                                <td>
                                                    <button class="btn btn-danger" onclick="setnonactive_galon()"><i class="fa fa-times"></i> Set Tidak Aktif</button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- TAB 2 --}}
                        <div class="tab-pane fade" id="panel2" role="tabpanel">
                            <div class="col-md-12 pull-left mt-3 table-responsive">
                                <table id="datatable-tipegalon-tidakaktif" class="table table-hover table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama Tipe Galon</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tipegalon_nonaktif as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->galon_type_name }}</td>
                                                <td>
                                                    <button class="btn btn-secondary" onclick="setactive_galon()"><i class="fa fa-times"></i> Aktifkan</button>
                                                </td>
                                            </tr>
                                        @endforeach
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