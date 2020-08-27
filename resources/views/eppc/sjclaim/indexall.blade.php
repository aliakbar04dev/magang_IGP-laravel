@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Surat Jalan Claim
        <small>Surat Jalan Claim</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> PPC KIM - TRANSAKSI</li>
        <li class="active"><i class="fa fa-files-o"></i> SURAT JALAN CLAIM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <p> 
                  @permission(['ppc-dnclaim-approve'])
                  <a target="_blank" class="btn btn-primary" href="{{ route('ppctdnclaimsj1s.scan') }}">
                    <span class="fa fa-plus"></span> Scan Surat Jalan Claim
                  </a>
                  @endpermission
                </p>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 5%;">No</th>
                      <th>Supplier</th>
                      <th style="width: 15%;">No. SJ</th>
                      <th style="width: 8%;">Tgl SJ</th>
                      <th style="width: 12%;">No. Certi</th>
                      <th style="width: 10%;">Tgl Certi</th>
                      <th style="width: 12%;">No. DN</th>
                      <th style="width: 12%;">Total QTY</th>
                      <th>Creaby</th>
                      <th>Submit</th>
                      <th>Approve</th>
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

    var url = '{{ route('dashboardall.ppctdnclaimsj1s') }}';
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
      "order": [[5, 'desc'],[4, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'no_sj', name: 'no_sj'},
        {data: 'tgl_sj', name: 'tgl_sj', className: "dt-center"},
        {data: 'no_certi', name: 'no_certi', className: "dt-center"},
        {data: 'tgl_certi', name: 'tgl_certi', className: "dt-center"},
        {data: 'no_dn', name: 'no_dn', className: "dt-center"},
        {data: 'total_qty', name: 'total_qty', className: "dt-right"},
        {data: 'creaby', name: 'creaby', className: "none", orderable: false, searchable: false},
        {data: 'pic_submit', name: 'pic_submit', className: "none", orderable: false, searchable: false},
        {data: 'pic_aprov', name: 'pic_aprov', className: "none", orderable: false, searchable: false}
      ]
    });
  });
</script>
@endsection