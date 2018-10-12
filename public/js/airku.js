$(document).ready(function() {

    $('#datatable-tipegalon').DataTable();
    $('#datatable-tipegalon-tidakaktif').DataTable();

	// KLIEN DATATABLE SERVERSIDE
    $('#datatable-klien').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_klien,
        columnDefs: [
        	{
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
        	},
        	{
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
        	},
        	{
                "targets": 2,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['created_at'];
                },
        	},
        	{
                "targets": 3,
                "orderable": false,
                "render": function ( data, type, row, meta ) {
	      			return '\
						<a href="klien/'+row['id']+'/view" class="btn btn-info btn-md"><i class="fa fa-search mr-1"></i> Detail</a>\
		      			<a onclick="suspendklien('+row['id']+')" class="btn btn-warning btn-md"><i class="fa fa-times mr-1"></i> Suspend</a>\
	      			';
			    }
        	}
    	]
    });

    $('#datatable-klien-pendaftar').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_klien_pendaftar,
        columnDefs: [
        	{
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
        	},
        	{
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
        	},
        	{
                "targets": 2,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['created_at'];
                },
        	},
        	{
                "targets": 3,
                "orderable": false,
                "render": function ( data, type, row, meta ) {
	      			return '\
						<a href="klien/'+row['id']+'/view" class="btn btn-info btn-md"><i class="fa fa-search mr-1"></i> Detail</a>\
		      			<a href="klien/'+row['id']+'/set-aktif" class="btn btn-secondary btn-md"><i class="fa fa-check mr-1"></i> Set Aktif</a>\
	      			';
			    }
        	}
    	]
    });

    $('#datatable-klien-tersuspend').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_klien_tersuspend,
        columnDefs: [
            {
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
            },
            {
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
            },
            {
                "targets": 2,
                "orderable": false,
                "render": function ( data, type, row, meta ) {
                    return '\
                        <a href="klien/'+row['id']+'/set-aktif" class="btn btn-secondary btn-md"><i class="fa fa-check mr-1"></i> Set Aktif</a>\
                    ';
                }
            }
        ]
    });


    // DEPOT GALON DATATABLE SERVERSIDE
    $('#datatable-depotgalon').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_depotgalon,
        columnDefs: [
            {
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
            },
            {
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
            },
            {
                "targets": 2,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['created_at'];
                },
            },
            {
                "targets": 3,
                "orderable": false,
                "render": function ( data, type, row, meta ) {
                    return '\
                        <a href="klien/'+row['id']+'/view" class="btn btn-info btn-md"><i class="fa fa-search mr-1"></i> Detail</a>\
                        <a onclick="suspendklien('+row['id']+')" class="btn btn-warning btn-md"><i class="fa fa-times mr-1"></i> Suspend</a>\
                    ';
                }
            }
        ]
    });

    $('#datatable-depotgalon-pendaftar').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_depotgalon_pendaftar,
        columnDefs: [
            {
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
            },
            {
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
            },
            {
                "targets": 2,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['created_at'];
                },
            },
            {
                "targets": 3,
                "orderable": false,
                "render": function ( data, type, row, meta ) {
                    return '\
                        <a href="depot-galon/'+row['id']+'/view" class="btn btn-info btn-md"><i class="fa fa-search mr-1"></i> Detail</a>\
                        <a onclick="suspendklien('+row['id']+')" class="btn btn-warning btn-md"><i class="fa fa-times mr-1"></i> Suspend</a>\
                    ';
                }
            }
        ]
    });

    $('#datatable-depotgalon-tersuspend').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_depotgalon_tersuspend,
        columnDefs: [
            {
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
            },
            {
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
            },
            {
                "targets": 2,
                "orderable": false,
                "render": function ( data, type, row, meta ) {
                    return '\
                        <a href="depot-galon/'+row['id']+'/view" class="btn btn-info btn-md"><i class="fa fa-search mr-1"></i> Detail</a>\
                        <a onclick="suspendklien('+row['id']+')" class="btn btn-warning btn-md"><i class="fa fa-times mr-1"></i> Suspend</a>\
                    ';
                }
            }
        ]
    });


    // REGISTERED CLIENT DATATABLE SERVERSIDE
    $('#datatable-registered-client').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_registered_client,
        columnDefs: [
            {
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
            },
            {
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
            },
            {
                "targets": 2,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['created_at'];
                },
            }
        ]
    });

    // REGISTERED DEPOT GALON DATATABLE SERVERSIDE
    $('#datatable-registered-depot-galon').DataTable({
        processing: true,
        serverSide: true,
        ajax: serverside_registered_depotgalon,
        columnDefs: [
            {
                "targets": 0,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['fullname'];
                },
            },
            {
                "targets": 1,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['email'];
                },
            },
            {
                "targets": 2,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['deposit'];
                },
            },
            {
                "targets": 3,
                "orderable": true,
                "render": function ( data, type, row ) {
                    return row['created_at'];
                },
            }
        ]
    });


});