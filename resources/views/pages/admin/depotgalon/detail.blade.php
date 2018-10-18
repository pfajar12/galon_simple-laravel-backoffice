@extends('layouts.adminlayout')

@section('title')
	Airku.id | Depot Galon
@endsection

@section('content')

	<div class="row wow fadeIn">
    	<div class="col-md-12 mb-4">
    		<div class="card">
    			<div class="card-body">
                    <h3 style="margin-bottom: 2%">Depot Galon Detail</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" value="{{ $galon->fullname }}" readonly="readonly">
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="{{ $galon->email }}" readonly="readonly">
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <input type="text" class="form-control" value="{{ $galon->status==1 ? 'aktif' : ($galon->status==0 ? 'tidak aktif' : 'tersuspend') }}" readonly="readonly">
                            </div>

                            <div class="form-group">
                                <label>Nilai Deposit</label>
                                @if($galon->status==1)
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target="#depositModal">
                                        <i class="fa fa-plus"></i> Tambah deposit
                                    </button>
                                @endif
                                <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#logDepositModal" onclick="get_log_deposit({{ $galon_id }})">
                                        <i class="fa fa-info-circle"></i> Lihat log deposit
                                    </button>
                                <input type="text" class="form-control" id="deposit-amount" readonly="readonly">
                            </div>

                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea class="form-control" readonly="readonly" rows="5">{{ $galon->address }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>No. Kontak</label>
                                <input type="text" class="form-control" value="{{ $galon->phone }}" readonly="readonly">
                            </div>

                            <div class="form-group">
                                <label>Tanggal Mendaftar</label>
                                <input type="text" class="form-control" value="{{ $galon->created_at }}" readonly="readonly">
                            </div>

                            <div class="form-group">
                                <label>Lokasi</label>
                                @if($galon->lat==null)
                                    <p>klien ini belum set lokasi</p>
                                @else
                                    <div id="map"></div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-12">
                            <a href="{{ route('admin.depotgalon') }}" class="btn btn-default btn-sm pull-left">Back</a>

                            @if($galon->status==1)
                                <a onclick="suspenddepotgalon({{ $galon_id }})" class="btn btn-warning btn-sm pull-right">Suspend</a>
                            @else
                                <a href="{{ route('admin.depotgalon.setaktif', ['id'=>$galon_id]) }}" class="btn btn-secondary btn-sm pull-right">Set Aktif</a>
                            @endif
                        </div>
                    </div>
    			</div>
			</div>
		</div>
	</div>

    <!-- Modal -->
    <div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah nilai deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Nilai deposit</label>
                        <input type="text" name="nilai_deposit" id="nilai_deposit" onkeypress="return hanyaAngka(event)" class="form-control" placeholder="contoh : 800000">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save_deposit()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="logDepositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Log deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Jumlah Deposit</th>
                                    <th>Ditambah/Disetujui Oleh</th>
                                    <th>Waktu</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-deposit-log-content">
                                
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {
            
            get_data();

        });

        function get_data() {
            var id = {{ $galon_id }}
            $.ajax({
                url: '../'+id+'/get-data',
                type: 'GET',
                data: {field: 'deposit'},
                beforeSend: function(){
                    $('#deposit-amount').val('sedang proses...')
                },
                success: function(param){
                    $('#deposit-amount').val(param)
                },
                error: function() {
                    swal.close();
                }
            });
        }

        function save_deposit() {
            var id = {{ $galon_id }}
            var nilai_deposit = $('#nilai_deposit').val();

            if(nilai_deposit==null){
                swal("Peringatan!", "Nilai deposit tidak boleh kosong", "warning");
            }
            else{
                $.ajax({
                    url: '{{ route('admin.depotgalon.setdeposit', ['id'=>$galon_id]) }}',
                    type: 'POST',
                    data: {id: id, nilai_deposit: nilai_deposit, "_token": "{{ csrf_token() }}"},
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
                        swal({
                            title: "",
                            text: "tambah nilai deposit berhasil",
                            icon: "success"
                        });

                        get_data();
                        $('#depositModal').modal('toggle');
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });
            }
        }

        function suspenddepotgalon(depot_id) {
            swal({
                title: "Anda yakin?",
                text: "Depot galon ini akan disuspend",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: '../'+depot_id+'/set-suspend',
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
                                   text: "Depot Galon berhasil di suspend",
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

        function get_log_deposit(id) {
            $('#tbody-deposit-log-content').empty();
            $.ajax({
                url: '{{ route('admin.logdeposit.perdepot', ['id'=>$galon_id]) }}',
                type: 'GET',
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
                    swal.close();
                    for(var i=0; i<param.length; i++){
                        $('#tbody-deposit-log-content').append('\
                            <tr>\
                                <td>'+param[i].deposit_amount+'</td>\
                                <td>'+param[i].fullname+'</td>\
                                <td>'+param[i].created_at+'</td>\
                            </tr>\
                        ')
                    }

                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        }

        function hanyaAngka(evt){
            var charCode=(evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57 ))
            return false;
            return true;
        }
        
        // MAP
        var mapProp= {
        center:new google.maps.LatLng({{ $galon->lat }}, {{ $galon->long }}),
        zoom:15,
        };
        var map=new google.maps.Map(document.getElementById("map"),mapProp);

        var marker, i;

        marker = new google.maps.Marker({
            position: new google.maps.LatLng({{ $galon->lat }}, {{ $galon->long }}),
            map: map,
            // icon: '../img/marker.png'
        });

    </script>

@endsection