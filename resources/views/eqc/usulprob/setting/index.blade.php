@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Usulan Problem
        <small>Daftar Usulan Problem</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li class="active"><i class="fa fa-files-o"></i> Usulan Problem</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['qc-usul-prob-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('usulprob.create') }}">
                    <span class="fa fa-plus"></span> Add Usulan
                  </a>
                </p>
              </div>
              <!-- /.box-header -->
              @endpermission
	            <div class="box-body">
                  <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-dropdown">           
                      <option value="kosong">Belum Diproses</option>
                      <option value="semua">Semua</option>
                      </select>
                      <input class="form-control" placeholder="Cari nama..." style="float:left;width:200px;margin: 0px 12px 10px 0px;" type="text" id="table-text-nama">
                      <input class="form-control" placeholder="Cari npk pembuat..." style="float:left;width:200px;margin: 0px 12px 10px 0px;" type="text" id="table-text-npk">
                      <input class="form-control" placeholder="Cari npk approv..." style="float:left;width:200px;margin: 0px 12px 10px 0px;" type="text" id="table-text-npk2">
                    <button class="btn btn-success reload" style="margin-left:10px" ><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                 <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th>Nama Problem</th>
                    <th>Pembuat</th>
                    <th>Disetujui</th>
                    <th style="width: 20%;">Action</th>
                  </tr>
                </thead>
    			      </table>
	            </div>
	            <!-- /.box-body -->

	          </div>
	          <!-- /.box -->
	        </div>
	        <!-- /.col -->
	      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <input type="hidden" id="reload" class="reload">
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    muncul()
    $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		cache: false,
		headers: { "cache-control": "no-cache" },
	});

    
    var isiData = "belumdiproses";
   	function muncul(){
      
      datatablemuncul()

      function datatablemuncul(){
        var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": [0],
	    render: function (data, type, row, meta) {
	        return meta.row + meta.settings._iDisplayStart + 1;
	    }
      },],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      bDestroy: true,
      ajax: {
        url: "{{ route('dashboard.usulprob') }}",
        type: 'GET',
        data: {
          isi:isiData
        }},
      columns: [
      	{data: null, name: null, className: "dt-center"},
        {data: 'nm_problem', name: 'nm_problem'},
        {data: 'creaby', name: 'creaby',orderable: false},
        {data: 'pic_aprov', name: 'pic_aprov'},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false},
	    ],
      dom:'ltipr'
    });

    $('#table-text-nama').on('keyup', function(){
          tableMaster.column(1).search(this.value).draw();   
    });  
    $('#table-text-npk').on('keyup', function(){
      tableMaster.column(2).search(this.value).draw();   
    });

    $('#table-text-npk2').on('keyup', function(){
      tableMaster.column(3).search('^$').draw();   
    });  
    $(".reload").on('click', function(e) {
       tableMaster.ajax.reload()
     });
      }

    $('#table-dropdown').on('change', function(){
     isiData = this.value;
     datatablemuncul();
    }); 
    


    

     }

  });
</script>
@endsection