@extends('layouts.adminlayout')

@section('title')
	Airku.id | Order List
@endsection

@section('content')

	<div class="row wow fadeIn">
    	<div class="col-md-12 mb-4">
    		<div class="card">
    			<div class="card-body">
                    <div class="tab-content">
                        <div class="col-md-12 pull-left mt-3 table-responsive">
                            <table id="datatable-order-list" class="table table-hover table-striped" width="100%">
                                <thead>
                                    <tr>
                                        <th>Klien</th>
                                        <th>Depot Galon</th>
                                        <th>Tipe Galon</th>
                                        <th>Qty</th>
                                        <th>Waktu Order</th>
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