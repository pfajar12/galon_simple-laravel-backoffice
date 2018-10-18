@extends('layouts.adminlayout')

@section('title')
	Airku.id | Log Deposit
@endsection

@section('content')

	<div class="row wow fadeIn">
    	<div class="col-md-12 mb-4">
    		<div class="card">
    			<div class="card-body">
                    <div class="tab-content">
                        <div class="col-md-12 pull-left mt-3 table-responsive">
                            <table id="datatable-log-deposit" class="table table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>Depot Galon</th>
                                        <th>Jumlah Deposit</th>
                                        <th>Ditambah/Disetujui Oleh</th>
                                        <th>Waktu</th>
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
    
@endsection