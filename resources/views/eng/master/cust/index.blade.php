@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Customer
        <small>Daftar Customer</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
        <li class="active"><i class="fa fa-files-o"></i> Customer</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              @permission('eng-msteng-create')
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('engtmcusts.create') }}">
                    <span class="fa fa-plus"></span> Add Customer
                  </a>
                </p>
              </div>
              <!-- /.box-header -->
              @endpermission
              <div class="box-body">
                <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 1%;">No</th>
                      <th>Kode Cust</th>
                      <th>Nama Cust</th>
                      <th>Kode BPID</th>
                      <th>Inisial</th>
                      <th>Alamat</th>
                      <th>Status</th>
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
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){

    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
      render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
      }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('dashboard.engtmcusts') }}",
      columns: [
        {data: null, name: null},
        {data: 'kd_cust', name: 'kd_cust'},
        {data: 'nm_cust', name: 'nm_cust'},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'inisial', name: 'inisial'},
        {data: 'alamat', name: 'alamat'},        
        {data: 'st_aktif', name: 'st_aktif'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  });
</script>
@endsection