@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Rayon
        <small>Daftar Rayon</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar Rayon</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_detail">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Rayon</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style='width: 1%;'>No</th>
                    <th style='width: 20%;'>Nama</th>
                    <th style='width: 20%;'>Lokasi</th>
                    <th>Alamat</th>
                    <th>Telepon</th>
                    <th>CP</th>
                    <th>Jasa</th>
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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('mobiles.dashboarddaftarrs') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        {data: 'nama_id', name: 'nama_id'},
        {data: 'nama_lokasi', name: 'nama_lokasi'},
        {data: 'alamat', name: 'alamat'},
        {data: 'telepon', name: 'telepon', className: "none"},
        {data: 'contact_person', name: 'contact_person', className: "none"},
        {data: 'nama_jasa', name: 'nama_jasa', className: "none"}
      ]
    });

    $(function() {
      $('\
        <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:10px;">\
          <label>Jasa \
          <select size="1" name="filter_status" aria-controls="filter_status" \
            class="form-control select2" style="width: 150px;">\
              <option value="ALL" selected="selected">Semua</option>\
              <option value="APOTIK">APOTIK</option>\
              <option value="DOKTER">DOKTER</option>\
              <option value="DOKTER GIGI">DOKTER GIGI</option>\
              <option value="KLINIK">KLINIK</option>\
              <option value="LAB">LAB</option>\
              <option value="OPTIK">OPTIK</option>\
              <option value="RUMAH SAKIT">RUMAH SAKIT</option>\
              <option value="OTHERS">OTHERS</option>\
            </select>\
          </label>\
        </div>\
      ').insertAfter('.dataTables_length');

      $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
        data.status = $('select[name="filter_status"]').val();
      });

      $('select[name="filter_status"]').change(function() {
        tableDetail.ajax.reload();
      });
    });
  });
</script>
@endsection