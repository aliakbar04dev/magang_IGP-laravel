@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Individual Development Plan
        <small><font color="red"><b>Approval HRD</b></font></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> HR - IDP Dept - Approval HRD</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar IDP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">IDP Dept Head</h3>
              </div>
              <div class="box-body form-horizontal">
                <div class="form-group">
                  <div class="col-sm-2">
                    {!! Form::label('lbltahun', 'Tahun') !!}
                    <select name="filter_status_tahun" aria-controls="filter_status" 
                      class="form-control select2">
                      @for ($i = \Carbon\Carbon::now()->format('Y')+1; $i > \Carbon\Carbon::now()->format('Y')-10; $i--)
                        @if ($i >= 2018)
                          @if ($i == \Carbon\Carbon::now()->format('Y') && \Carbon\Carbon::now()->format('m') < "11")
                            <option value={{ $i }} selected="selected">{{ $i }}</option>
                          @else
                            <option value={{ $i }}>{{ $i }}</option>
                          @endif
                        @endif
                      @endfor
                    </select>
                  </div>
                  <div class="col-sm-4">
                    {!! Form::label('lbldep', 'Departemen') !!}
                    <select name="filter_dep" aria-controls="filter_status" class="form-control select2">
                      <option value="ALL" selected="selected">ALL</option>
                      @foreach($departement->get() as $kode)\
                        <option value="{{$kode->kd_dep}}">{{$kode->desc_dep}} - {{$kode->kd_dep}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-3">
                    {!! Form::label('lblstatus', 'Status') !!}
                    <select name="filter_status" aria-controls="filter_status" class="form-control select2">
                      <option value="ALL" selected="selected">ALL</option>
                      <option value="DRAFT">DRAFT</option>
                      <option value="SUBMIT">SUBMIT</option>
                      <option value="REJECT">REJECT</option>
                      <option value="APPROVE DIVISI">APPROVE DIVISI</option>
                      <option value="APPROVE HRD">APPROVE HRD</option>
                      <option value="SUBMIT (MID)">SUBMIT (MID)</option>
                      <option value="REJECT (MID)">REJECT (MID)</option>
                      <option value="APPROVE DIVISI (MID)">APPROVE DIVISI (MID)</option>
                      <option value="APPROVE HRD (MID)">APPROVE HRD (MID)</option>
                      <option value="SUBMIT (ONE)">SUBMIT (ONE)</option>
                      <option value="REJECT (ONE)">REJECT (ONE)</option>
                      <option value="APPROVE DIVISI (ONE)">APPROVE DIVISI (ONE)</option>
                      <option value="APPROVE HRD (ONE)">APPROVE HRD (ONE)</option>
                    </select>
                  </div>
                </div>
                <!-- /.form-group -->
              </div>
              <!-- /.box-body -->
              <div class="box-body">
                <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style="width: 1%;">No</th>
                      <th>NPK</th>
                      <th style="width: 1%;">Rev</th>
                      <th style="width: 25%;">Department</th>
                      <th style="width: 15%;">Position</th>
                      <th style="width: 20%;">Status</th>
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

  //Initialize Select2 Elements
  $(".select2").select2();

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
      ajax: "{{ route('dashboardapprovalhrd.hrdtidpdep1s') }}",
      columns: [
        {data: null, name: null},
        {data: 'npk', name: 'npk'},
        {data: 'revisi', name: 'revisi', className: "dt-center"},
        {data: 'kd_dep', name: 'kd_dep'},
        {data: 'cur_pos', name: 'cur_pos'},
        {data: 'status', name: 'status'},
        {data: 'action', name: 'action', orderable: false, searchable: false}
      ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('select[name="filter_status_tahun"]').val();
      data.status = $('select[name="filter_status"]').val();
      data.kd_dep = $('select[name="filter_dep"]').val();
    });

    $('select[name="filter_status_tahun"]').change(function() {
      tableMaster.ajax.reload();
    });

    $('select[name="filter_status"]').change(function() {
      tableMaster.ajax.reload();
    });

    $('select[name="filter_dep"]').change(function() {
      tableMaster.ajax.reload();
    });
  });
</script>
@endsection