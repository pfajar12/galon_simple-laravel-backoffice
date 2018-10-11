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
                            <div class="col-md-12 mb-4">
                                <button data-toggle="modal" data-target="#tipeGalonModal" class="btn btn-warning btn-md waves-effect pull-right">
                                    <i class="fa fa-plus mr-1"></i> Add Data
                                </button>
                            </div>
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
                                                    <button class="btn btn-danger" onclick="setnonactive_galon({{ $data->id }})"><i class="fa fa-times"></i> Set Tidak Aktif</button>
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
                                                    <a class="btn btn-secondary" href="{{ route('admin.tipegalon.restore', ['id'=>$data->id]) }}"><i class="fa fa-times"></i> Aktifkan</a>
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

    <!-- Modal -->
    <div class="modal fade" id="tipeGalonModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah tipe galon</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Tipe Galon</label>
                        <input type="text" name="tipe_galon" id="tipe_galon" class="form-control" placeholder="contoh : Mindy">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_tipe_galon()">Save</button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">
        
        function save_tipe_galon(argument) {
            var tipe_galon = $("#tipe_galon").val();

            if(tipe_galon==""){
                swal("Peringatan!", "Tipe galon tidak boleh kosong", "warning");
            }
            else{
                $.ajax({
                    url: '{{ route('admin.tipegalon.store') }}',
                    type: 'POST',
                    data: {tipe_galon: tipe_galon, "_token": "{{ csrf_token() }}"},
                    beforeSend: function(){
                        swal({
                            title: "Please Wait",
                            text: "Processing data...",
                            icon: "warning",
                            buttons: false,
                            closeOnEsc: false
                        });
                    },
                    success: function(param){
                        if(param=='success'){
                            swal({
                                title: "",
                                text: "tambah tipe galon berhasil",
                                icon: "success"
                            })
                            .then((willreload) => {
                                if(willreload){
                                    location.reload();
                                }
                            })
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            }
        }

        function setnonactive_galon(id) {
            swal({
                title: "Anda yakin?",
                text: "Data ini akan diset non aktif",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: 'tipe-galon/'+id+'/setnonactive',
                        type: 'GET',
                        beforeSend: function(){
                            swal({
                                title: "Mohon tunggu",
                                text: "data sedang diproses...",
                                icon: "warning",
                                buttons: false,
                                closeOnEsc: false
                            });
                        },
                        success: function(param){
                            if(param=="success"){
                                swal({
                                   title: "Berhasil",
                                   text: "Tipe galon berhasil diset non aktif",
                                   icon: "success"
                                })
                                .then(() => {
                                    location.reload();
                                });
                            }
                        },
                        error: function() {
                            swal.close();
                        }
                    });
                }
            });
        }

    </script>

@endsection