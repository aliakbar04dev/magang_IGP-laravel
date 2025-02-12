@extends('layouts.app')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Ijin Meninggalkan Pekerjaan ( IMP )
      <small></small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="glyphicon glyphicon-info-sign"></i> IMP</li>
      <li class="active"><i class="fa fa-files-o"></i> Ijin Meninggalkan Pekerjaan (IMP) </li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="row" id="field_detail">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title"><b>Ijin Meninggalkan Pekerjaan (IMP)</b></h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
              </button>
            </div>
            <hr>
            <div class="box-header">
              <p> 
               
                <a class="btn btn-primary" href="{{ route('mobiles.createimp') }}">
                  <span class="fa fa-plus"></span> IMP Pengajuan
                </a>

       {{--          <div class="alert alert-info">
                  <strong>Perhatian!</strong>
                  <ul>
                  <li>Hubungi atasan masing-masing untuk konfirmasi permohonan melalui sistem pengajuan ijin meninggalkan pekerjaan</li>
                  <li>Setelah permohonan disetujui, pemohon dapat mencetak bukti persetujuan permohonan sebagai bukti telah disetujui oleh atasan</li>
                </div>   --}}           
              </p>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">         
         <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style='width: 1%;'>No</th>
                  <th style='width: 7%;'>TGL</th>                
                  <th style='width: 5%;'>Jam </th>
                  <th style='width: 5%;'>Keperluan</th>
                  <th style='width: 10%;'>Status</th>
                  <th style='width: 10%;'>ACTION</th>
          {{--         <th style='width: 7%;'>Action</th> --}}
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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      ajax: "{{ route('mobiles.dashboardimp') }}",
      columns: [
      {data: null, name: null, orderable: false, searchable: false},
      {data: 'tglijin', name: 'tglijin'},
      {data: 'jamimp', name: 'jamimp'},
      {data: 'keperluan', name: 'keperluan'},
      {data: 'status', name: 'status'},
      {data: 'action', name: 'action'}
      // {data: 'action', name: 'status'},
      
      ]
    });
  });
</script>
@endsection