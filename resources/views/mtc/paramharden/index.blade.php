@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Parameter Hardening
        <small>Daftar Parameter Hardening</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>Home</a></li>
        <li><i class="fa fa-files-o"></i> MTC - Parameter Hardening Follow Up</li>
        <li class="active"><i class="fa fa-files-o"></i>Parameter Hardening Follow Up</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-body">
                <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 1%;">No</th>
                      <th>No Doc</th>
                      <th>mesin</th>
                      <th>Part No</th>
                      <th>Tanggal</th>
                      <th>Shift</th>
                      {{-- <th>Coil LH</th> --}}
                      {{-- <th>Coil RH</th> --}}
                      <th>qty</th>
                      <th>posisi</th>
                      {{-- <th>qw temp std</th>
                      <th>qw temp act</th>
                      <th>cw temp std</th>
                      <th>cw temp act</th>
                      <th>ct std</th>
                      <th>ct act</th>  
                      <th>qfr std</th>
                      <th>qfr act</th>  
                      <th>qfl std</th>
                      <th>qfl act</th>  
                      <th>home pos</th>
                      <th>start pos</th>
                      <th>lower lim</th>
                      <th>upper lim</th>  --}}                   
                      <th>Judge</th>
                      <th>Tgl Follow Up</th>
                      <th>Action</th>
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
    var url = "{{ route('mtcparamhardenfollow.dashboard') }}";
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
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'no_doc', name: 'no_doc'},
        {data: 'mesin', name: 'mesin'},
        {data: 'partno', name: 'partno'},
        {data: 'tanggal', name: 'tanggal'},
        {data: 'shift', name: 'shift'},
        // {data: 'coil_lh', name: 'coil_lh'},
        // {data: 'coil_rh', name: 'coil_rh'},
        {data: 'qty', name: 'qty'},
        {data: 'posisi', name: 'posisi'},
        // {data: 'qw_temp_std', name: 'qw_temp_std'},
        // {data: 'qw_temp_act', name: 'qw_temp_act'},
        // {data: 'cw_temp_std', name: 'cw_temp_std'},
        // {data: 'cw_temp_act', name: 'cw_temp_act'},
        // {data: 'ct_std', name: 'ct_std'},
        // {data: 'ct_act', name: 'ct_act'},
        // {data: 'qfr_std', name: 'qf_std'},
        // {data: 'qfr_act', name: 'qf_act'},
        // {data: 'qfl_std', name: 'qf_std'},
        // {data: 'qfl_act', name: 'qf_act'},
        // {data: 'home_pos', name: 'home_pos'},
        // {data: 'start_pos', name: 'start_pos'},
        // {data: 'lower_lim', name: 'lower_lim'},
        // {data: 'upper_lim', name: 'upper_lim'},
        {data: 'judge', name: 'judge'},
        {data: 'tgl_follow_up', name: 'tgl_follow_up'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });
  });
</script>
@endsection