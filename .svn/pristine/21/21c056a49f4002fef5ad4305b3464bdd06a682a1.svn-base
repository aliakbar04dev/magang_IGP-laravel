@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Item Pengecekan
        <small>Daftar Item</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li class="active"><i class="fa fa-files-o"></i> Item Pengecekan</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              @permission(['mtc-master-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('mtcmasicheck.create') }}">
                    <span class="fa fa-plus"></span> Add Item
                  </a>
                </p>
              </div>
              <!-- /.box-header -->
              @endpermission
	            <div class="box-body">
                  <select autocomplete="off" class="form-control" style="width:150px;float:left;margin: 0px 12px 10px 0px;" id="table-dropdown">           
                      <option value="">Semua</option>
                    <option value="T">AKTIF</option>
                      <option value="F">TIDAK AKTIF</option>
                       
                      </select></button>
                      <button class="btn btn-success reload" style="margin-left:10px" ><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
	              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                 <thead>
                  <tr>
                    <th style="width: 1%;">Kode</th>
                    <th>Nama</th>
                    <th>Status Aktif</th>
                    <th style="width: 5%;">Action</th>
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

    

   	function muncul(){
      var tableMaster = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [[0, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      bDestroy: true,
      ajax: "{{ route('dashboard.mtcmasicheck') }}",
      columns: [
        {data: 'no_ic',name:'no_ic',className: "dt-center"},
        {data: 'nm_ic', name: 'nm_ic'},
        {data: 'st_aktif', name: 'st_aktif'},
        {data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
	    ],
      searching: true,
      "deferRender": true,
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        // initTable(window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var kd_mesin = tableMaster.cell(index, 1).data();
          var regex = /(<([^>]+)>)/ig;
          // initTable(window.btoa(kd_mesin.replace(regex, "")));
        }
      }
    });

    $('#table-dropdown').ready(function(){
              tableMaster.column(2).search('').draw(); 
        });    

        $('#table-dropdown').on('change', function(){
            tableMaster.column(2).search(this.value).draw();            
        }); 

        $(".reload").on('click', function(e) {
       tableMaster.ajax.reload()
     });

     }
   
  });
</script>
@endsection