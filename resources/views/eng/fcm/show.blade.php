@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        FCM
        <small>Detail Form Characteristic Matrix</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - TRANSAKSI - FCM</li>
        <li><a href="{{ route('engttpfc1s.index') }}"><i class="fa fa-files-o"></i> Daftar FCM</a></li>
        <li class="active">Detail FCM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">FCM</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 15%;"><b>Registrasi Doc</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $engtfcm1->reg_no_doc }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>No. OP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $engtfcm1->no_op }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>M/C Code # Type # Name</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $engtfcm1->kd_mesin }}</td>
                  </tr>
                  @if (!empty($engtfcm1->pict_dim_position))
                    <tr>
                      <td style="width: 15%;"><b>Dimension Position</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        <div class="box box-primary collapsed-box">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="boxtitle">File</h3>
                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-12">
                                <p>
                                  <img src="{{ $engtfcm1->pict($engtfcm1->pict_dim_position) }}" alt="File Not Found" class="img-rounded img-responsive">
                                </p>
                              </div>
                            </div>
                            <!-- /.form-group -->
                          </div>
                          <!-- ./box-body -->
                        </div>
                        <!-- /.box -->
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 15%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($engtfcm1->dtcrea))
                        {{ $engtfcm1->creaby }} - {{ $engtfcm1->nama($engtfcm1->creaby) }} - {{ \Carbon\Carbon::parse($engtfcm1->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $engtfcm1->creaby }} - {{ $engtfcm1->nama($engtfcm1->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($engtfcm1->dtmodi))
                        {{ $engtfcm1->modiby }} - {{ $engtfcm1->nama($engtfcm1->modiby) }} - {{ \Carbon\Carbon::parse($engtfcm1->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $engtfcm1->modiby }} - {{ $engtfcm1->nama($engtfcm1->modiby) }}
                      @endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail FCM</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $engtfcm1->id }}">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 20%;">Dimension Status</th>
                    <th>Process Requirement</th>
                    <th style="width: 25%;">Standard</th>
                    <th>ID</th>
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
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><p id="info-detail2">FCM 3</p></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblFcm3" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" style="width: 1%;">No</th>
                    <th rowspan="2" style="width: 25%;">Tolerance</th>
                    <th rowspan="2" style="width: 25%;">Dimension/Note Status</th>
                    <th colspan="{{ $engtfcm1->engtTpfc1()->engtTpfc2s()->get()->count() }}" style="text-align:center;">Process No</th>
                  </tr>
                  <tr>
                    @foreach ($engtfcm1->engtTpfc1()->engtTpfc2s()->orderBy("no_op")->get() as $engttpfc2)
                      <th style="text-align:center;width: 2%;">{{ $engttpfc2->no_op }}</th>
                    @endforeach
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
      <div class="box-footer">
        @if (Auth::user()->can(['eng-fcm-create']) && $engtfcm1->checkEdit() === "T")
          @if (Auth::user()->can('eng-fcm-create'))
            <a class="btn btn-primary" href="{{ route('engtfcm1s.edit', base64_encode($engtfcm1->id)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('engtfcm1s.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard FCM">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    var engt_fcm1_id = $('#field').data("field-id");
    var url = '{{ route('engtfcm1s.detailfcm2', 'param') }}';
    url = url.replace('param', window.btoa(engt_fcm1_id));
    var tableDetail = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[0, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: 'no_urut', name: 'no_urut', className: "dt-center"}, 
        { data: 'dim_st', name: 'dim_st'}, 
        { data: 'pros_req', name: 'pros_req'}, 
        { data: 'std', name: 'std'}, 
        { data: 'id', name: 'id', className: "none", orderable: false, searchable: false}
      ],
    });

    $('#tblDetail tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail2").innerHTML = 'FCM 3';
        initTable2(window.btoa("0"));
      } else {
        tableDetail.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableDetail.rows().count() > 0) {
          var index = tableDetail.row('.selected').index();
          var no_urut = tableDetail.cell(index, 0).data();
          var engt_fcm2_id = tableDetail.cell(index, 4).data();
          var info = "No. Urut: " + no_urut;
          document.getElementById("info-detail2").innerHTML = 'FCM 3 (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable2(window.btoa(engt_fcm2_id));
        }
      }
    });

    var urlFcm3 = '{{ route('engtfcm1s.detailfcm3', 'param') }}';
    urlFcm3 = urlFcm3.replace('param', window.btoa("0"));
    var tableFcm3 = $('#tblFcm3').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: urlFcm3,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'tolerance', name: 'tolerance'},
        { data: 'dim_note_st', name: 'dim_note_st'},
        @for ($i = 1; $i <= $engtfcm1->engtTpfc1()->engtTpfc2s()->get()->count(); $i++)
          @if($i == $engtfcm1->engtTpfc1()->engtTpfc2s()->get()->count()) 
            {data: 'st_pros_{{ $i }}', name: 'st_pros_{{ $i }}', className: "dt-center"}
          @else 
            {data: 'st_pros_{{ $i }}', name: 'st_pros_{{ $i }}', className: "dt-center"},
          @endif
        @endfor
      ],
    });

    function initTable2(engt_fcm2_id) {
      tableFcm3.search('').columns().search('').draw();
      var urlFcm3 = '{{ route('engtfcm1s.detailfcm3', 'param') }}';
      urlFcm3 = urlFcm3.replace('param', engt_fcm2_id);
      tableFcm3.ajax.url(urlFcm3).load();
    }

    if(tableDetail.rows().count() > 0) {
      $('#tblDetail tbody tr:eq(0)').click(); 
    }
  });

  setTimeout(function(){
    var tableDetail = $('#tblDetail').DataTable();
    if(tableDetail.rows().count() > 0) {
      $('#tblDetail tbody tr:eq(0)').click(); 
    }
  }, 1000);
</script>
@endsection