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
                                <input type="text" class="form-control" value="{{ $galon->deposit }}" readonly="readonly">
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


    <script type="text/javascript">

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