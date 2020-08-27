@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Kategori
        <small>Master Kategori</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - Master</li>
        <li class="active"><i class="fa fa-files-o"></i> Kategori</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              @permission(['budget-cr-kategori-create'])
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('bgttcrkategors.create') }}">
                    <span class="fa fa-plus"></span> Add Kategori
                  </a>
                </p>
              </div>
              <!-- /.box-header -->
              @endpermission
              <div class="box-body">
                <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 5%;text-align: center">No</th>
                      <th>Kategori</th>
                      <th style="width: 30%;">Klasifikasi</th>
                      <th style="width: 10%;">Aktif</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
                      <th style="width: 10%;text-align: center">Action</th>
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
      ajax: "{{ route('bgttcrkategors.dashboard') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'nm_kategori', name: 'nm_kategori'},
        {data: 'nm_klasifikasi', name: 'nm_klasifikasi'},
        {data: 'st_aktif', name: 'st_aktif', className: "dt-center"},
        {data: 'creaby', name: 'creaby', orderable: false, searchable: false, className: "none"},
        {data: 'modiby', name: 'modiby', orderable: false, searchable: false, className: "none"},
        {data: 'action', name: 'action', orderable: false, searchable: false, className: "dt-center"}
      ]
    });
  });
</script>
@endsection