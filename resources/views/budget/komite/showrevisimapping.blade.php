@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        History Komite Investasi
        <small>Detail History Komite Investasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('bgttkomite1s.all') }}"><i class="fa fa-files-o"></i> Mapping Komite Investasi</a></li>
        <li class="active">Detail History {{ $bgttkomite1->no_komite }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">History Komite Investasi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Komite</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $bgttkomite1->no_komite }}</td>
                    <td style="width: 10%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttkomite1->no_rev }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Tgl Daftar Komite</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ \Carbon\Carbon::parse($bgttkomite1->dtcrea)->format('d/m/Y') }}</td>
                    <td style="width: 10%;"><b>Tgl Pengajuan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($bgttkomite1->tgl_pengajuan)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $bgttkomite1->kd_dept }} - {{ $bgttkomite1->namaDepartemen($bgttkomite1->kd_dept) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Presenter</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $bgttkomite1->npk_presenter }} - {{ $bgttkomite1->nm_presenter }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Topik</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $bgttkomite1->topik }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Jenis Komite</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $bgttkomite1->jns_komite }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. IA/EA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttkomite1->no_ie_ea }}
                      @if($bgttkomite1->jns_komite === "OPS" || $bgttkomite1->jns_komite === "IA") 
                        <button id="btnmonitoring" name="btnmonitoring" type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#monitoringModal">
                          <span class="glyphicon glyphicon-eye-open"></span>
                        </button>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Catatan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $bgttkomite1->catatan }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Support User</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @foreach ($bgttkomite1->bgttKomite2s()->where("planning", "=", "T")->get() as $bgttKomite2)
                        {{ $loop->iteration }}. {{ $bgttKomite2->npk_support }} - {{ $bgttKomite2->nama_support }} <br>
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Tgl Komite Aktual</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      @if (!empty($bgttkomite1->tgl_komite_act))
                        {{ \Carbon\Carbon::parse($bgttkomite1->tgl_komite_act)->format('d/m/Y H:i') }}
                      @endif
                    </td>
                    <td style="width: 10%;"><b>Lokasi Komite</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($bgttkomite1->tgl_komite_act))
                        {{ $bgttkomite1->lok_komite_act }} - {{ $bgttkomite1->nm_lokasi }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>PIC Komite Aktual</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($bgttkomite1->tgl_komite_act))
                        {{ $bgttkomite1->pic_komite_act }} - {{ $bgttkomite1->namaByNpk($bgttkomite1->pic_komite_act) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Dihadiri</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @foreach ($bgttkomite1->bgttKomite2s()->where("act", "=", "T")->get() as $bgttKomite2)
                        {{ $loop->iteration }}. {{ $bgttKomite2->npk_support }} - {{ $bgttKomite2->nama_support }} <br>
                      @endforeach
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Presenter Aktual</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if($bgttkomite1->npk_presenter_act != null)
                        {{ $bgttkomite1->npk_presenter_act }} - {{ $bgttkomite1->nm_presenter_act }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Latar Belakang</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if($bgttkomite1->latar_belakang != null) 
                        {!! Form::textarea('latar_belakang', $bgttkomite1->latar_belakang, ['class'=>'form-control', 'placeholder' => 'Latar Belakang', 'rows' => '5', 'maxlength' => 1000, 'style' => 'resize:vertical', 'id' => 'latar_belakang', 'disabled']) !!}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Notulen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if($bgttkomite1->notulen != null)
                        {!! Form::textarea('notulen', $bgttkomite1->notulen_komite, ['class'=>'form-control', 'placeholder' => 'Notulen', 'rows' => '10', 'maxlength' => 5000, 'style' => 'resize:vertical', 'id' => 'notulen', 'disabled']) !!}
                      @endif 
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Estimasi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if($bgttkomite1->estimasi != null) 
                        {!! Form::textarea('estimasi', $bgttkomite1->estimasi, ['class'=>'form-control', 'placeholder' => 'Estimasi', 'rows' => '3', 'maxlength' => 100, 'style' => 'resize:vertical', 'id' => 'estimasi', 'disabled']) !!}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Hasil Komite</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if($bgttkomite1->hasil_komite != null)
                        {{ $bgttkomite1->hasil_komite }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttkomite1->creaby }} - {{ $bgttkomite1->namaByNpk($bgttkomite1->creaby) }} - {{ \Carbon\Carbon::parse($bgttkomite1->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($bgttkomite1->dtmodi))
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttkomite1->modiby }} - {{ $bgttkomite1->namaByNpk($bgttkomite1->modiby) }} - {{ \Carbon\Carbon::parse($bgttkomite1->dtmodi)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttkomite1->lok_file))
                    <tr>
                      <td style="width: 12%;"><b>File</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        <div class="box box-primary collapsed-box">
                          <div class="box-header with-border">
                            <h3 class="box-title" id="boxtitle">File</h3>
                            <div class="box-tools pull-right">
                              <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('bgttkomite1s.downloadfile', base64_encode($bgttkomite1->no_komite)) }}">
                                <span class='glyphicon glyphicon-download-alt'></span>
                              </a>
                              <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <div class="row form-group">
                              <div class="col-sm-12">
                                <p>
                                  <center>
                                    <iframe src="{{ $bgttkomite1->file($bgttkomite1->lok_file) }}" width="100%" height="400px"></iframe>
                                  </center>
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
              <h3 class="box-title">Item to be Follow Up</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $bgttkomite1->no_komite }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 5%;">Seq</th>
                    <th>Keterangan</th>
                    <th style="width: 25%;">Approval 1</th>
                    <th style="width: 25%;">Approval 2</th>
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
        <a class="btn btn-primary" href="{{ route('bgttkomite1s.all') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Daftar Mapping Komite Investasi">Mapping Komite Investasi</a>
        &nbsp;&nbsp;
        <a class="btn btn-primary" href="{{ route('bgttkomite1s.allnotulen') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Daftar Notulen Komite Investasi">Notulen Komite Investasi</a>
        &nbsp;&nbsp;
        <a class="btn btn-primary" href="#" onclick="window.open('', '_self', ''); window.close();" data-toggle="tooltip" data-placement="top" title="Close Tab">Close</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  @include('budget.komite.popup.monitoringModal')
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    var no_komite = $('#field').data("field-id");
    var url = '{{ route('bgttkomite1s.detail', 'param') }}';
    url = url.replace('param', window.btoa(no_komite));
    var tableDetail = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [[0, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: 'no_seq', name: 'no_seq', className: "dt-center"},
        { data: 'ket_item', name: 'ket_item'},
        { data: 'pic_apr1', name: 'pic_apr1'},
        { data: 'pic_apr2', name: 'pic_apr2'}
      ],
    });

    $("#btnmonitoring").click(function(){
      popupMonitoring();
    });
  });

  function popupMonitoring() {
    var no_ie_ea = "{{ $bgttkomite1->no_ie_ea }}";
    if(no_ie_ea === "") {
      no_ie_ea = "-";
    }
    var jns_komite = "{{ $bgttkomite1->jns_komite }}";
    var myHeading;
    var url;
    if(jns_komite === "OPS") {
      myHeading = "<p>Monitoring OH (" + no_ie_ea + ")</p>";
      url = '{{ route('datatables.popupMonitoringOH', 'param') }}';
    } else {
      myHeading = "<p>Monitoring IA/EA (" + no_ie_ea + ")</p>";
      url = '{{ route('datatables.popupMonitoringIA', 'param') }}';
    }
    $("#monitoringModalLabel").html(myHeading);
    url = url.replace('param', window.btoa(no_ie_ea));
    var lookupMonitoring = $('#lookupMonitoring').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      paging: false, 
      searching: false, 
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
          { data: 'no_urut', name: 'no_urut', className: 'dt-right'},
          { data: 'progress', name: 'progress'}, 
          { data: 'npk_approve', name: 'npk_approve'}, 
          { data: 'tgl_approve', name: 'tgl_approve'}, 
          { data: 'remark', name: 'remark'}, 
          { data: 'std_hari', name: 'std_hari', className: 'dt-right'}, 
          { data: 'act_hari', name: 'act_hari', className: 'dt-right'}
      ],
      "bDestroy": true,
    });
  }
</script>
@endsection