@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Ulang Tahun
        <small>Daftar Ulang Tahun</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar Ulang Tahun</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Ulang Tahun</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-horizontal">
              <div class="form-group">
                <div class="col-sm-3">
                  {!! Form::label('lblawal', 'Tgl Awal') !!}
                  {!! Form::date('filter_tgl_awal', \Carbon\Carbon::now()->startOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl_awal']) !!}
                </div>
                <div class="col-sm-3">
                  {!! Form::label('lblakhir', 'Tgl Akhir') !!}
                  {!! Form::date('filter_tgl_akhir', \Carbon\Carbon::now()->endOfMonth(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'filter_tgl_akhir']) !!}
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
            <div class="box-body">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style='width: 5%;'>No</th>
                    <th style='width: 5%;'>NPK</th>
                    <th>Nama</th>
                    <th style='width: 10%;'>Tgl Lahir</th>
                    <th style='width: 5%;'>PT</th>
                    <th style='width: 35%;'>Departemen</th>
                    <th>Divisi</th>
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

    var tableDetail = $('#tblDetail').DataTable({
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
      "order": [[3, 'asc'],[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('mobiles.dashboarddob') }}",
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'npk', name: 'npk', className: "dt-center"},
        {data: 'nama', name: 'nama'},
        {data: 'tgl_lahir', name: 'tgl_lahir', className: "dt-center"},
        {data: 'kd_pt', name: 'kd_pt', className: "dt-center"},
        {data: 'desc_dep', name: 'desc_dep'}, 
        {data: 'desc_div', name: 'desc_div', className: "none"}
      ]
    });

    $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="filter_tgl_awal"]').val();
      data.tgl_akhir = $('input[name="filter_tgl_akhir"]').val();
    });

    $('#display').click( function () {
      tableDetail.ajax.reload();
    });

    //$('#display').click();
  });
</script>
@endsection