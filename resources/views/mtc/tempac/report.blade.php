@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Temperature AC
        <small>Laporan Temperature AC</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Laporan</li>
        <li class="active"><i class="fa fa-files-o"></i> Temperature AC</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('filter_tahun', 'Tahun') !!}
              <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
              class="form-control select2">
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                  @if (isset($tahun))
                    @if ($i == $tahun)
                      <option value={{ $i }} selected="selected">{{ $i }}</option>
                    @else
                      <option value={{ $i }}>{{ $i }}</option>
                    @endif
                  @else 
                    @if ($i == \Carbon\Carbon::now()->format('Y'))
                      <option value={{ $i }} selected="selected">{{ $i }}</option>
                    @else
                      <option value={{ $i }}>{{ $i }}</option>
                    @endif
                  @endif
                @endfor
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Bulan') !!}
              <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
              class="form-control select2">
                @if (isset($bulan))
                  <option value="01" @if ("01" == $bulan) selected="selected" @endif>Januari</option>
                  <option value="02" @if ("02" == $bulan) selected="selected" @endif>Februari</option>
                  <option value="03" @if ("03" == $bulan) selected="selected" @endif>Maret</option>
                  <option value="04" @if ("04" == $bulan) selected="selected" @endif>April</option>
                  <option value="05" @if ("05" == $bulan) selected="selected" @endif>Mei</option>
                  <option value="06" @if ("06" == $bulan) selected="selected" @endif>Juni</option>
                  <option value="07" @if ("07" == $bulan) selected="selected" @endif>Juli</option>
                  <option value="08" @if ("08" == $bulan) selected="selected" @endif>Agustus</option>
                  <option value="09" @if ("09" == $bulan) selected="selected" @endif>September</option>
                  <option value="10" @if ("10" == $bulan) selected="selected" @endif>Oktober</option>
                  <option value="11" @if ("11" == $bulan) selected="selected" @endif>November</option>
                  <option value="12" @if ("12" == $bulan) selected="selected" @endif>Desember</option>
                @else 
                  <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                  <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                  <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                  <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                  <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                  <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                  <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                  <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                  <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                  <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                  <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                  <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                @endif
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('kd_plant', 'Plant') !!}
              <select size="1" id="kd_plant" name="kd_plant" class="form-control select2" onchange="changeKdPlant()">
                @if (isset($kd_plant))
                  <option value="ALL">Pilih Plant</option>
                  @foreach($plant->get() as $kode)
                    <option value="{{ $kode->kd_plant }}" @if ($kode->kd_plant == $kd_plant) selected="selected" @endif>{{ $kode->nm_plant }}</option>
                  @endforeach
                @else 
                  <option value="ALL" selected="selected">Pilih Plant</option>
                  @foreach($plant->get() as $kode)
                    <option value="{{ $kode->kd_plant }}">{{ $kode->nm_plant }}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('kd_line', 'Line (F9)') !!}
              <div class="input-group">
                @if (isset($kd_line))
                  {!! Form::text('kd_line', $kd_line, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                @else 
                  {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                @endif
                <span class="input-group-btn">
                  <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-4">
              {!! Form::label('nm_line', 'Nama Line') !!}
              @if (isset($nm_line))
                {!! Form::text('nm_line', $nm_line, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
              @else 
                {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
              @endif
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('lblusername2', ' ') !!}
              <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
        @if (isset($mtcttempacs))
          <div class="box-body">
            <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <caption style="display: table-caption;"><strong>Tahun: {{ $tahun }}, Bulan: {{ $bulan }}, Plant: {{ $kd_plant }}, Line: {{ $kd_line }} - {{ $nm_line }}</strong></center></caption>
              <thead>
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Mesin</th>
                  <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Nama Mesin</th>
                  <th rowspan="2" style="text-align: center">Satuan</th>
                  <th colspan="31" style="text-align: center">Tgl</th>
                </tr>
                <tr>
                  @for($i = 1; $i <= 31; $i++)
                    <th style="text-align: center">{{ $i }}</th>
                  @endfor
                </tr>
              </thead>
              <tbody>
                @foreach ($mtcttempacs->get() as $data)
                  <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->kd_mesin }}
                    </td>
                    <td style="white-space: nowrap;max-width: 400px;overflow: auto;text-overflow: clip;">
                      {{ $data->nm_mesin }}
                    </td>
                    <td style="text-align: center">
                      °C
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_1) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_2) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_3) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_4) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_5) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_6) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_7) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_8) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_9) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_10) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_11) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_12) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_13) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_14) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_15) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_16) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_17) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_18) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_19) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_20) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_21) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_22) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_23) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_24) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_25) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_26) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_27) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_28) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_29) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_30) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->tgl_31) }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        @endif
      </div>
      <!-- /.box -->
      <!-- Modal Line -->
      @include('mtc.lp.popup.lineModal')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  document.getElementById("filter_tahun").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('btn-display').focus();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(kd_plant));
    var lookupLine = $('#lookupLine').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true,
      "order": [[1, 'asc']],
      columns: [
        { data: 'xkd_line', name: 'xkd_line'},
        { data: 'xnm_line', name: 'xnm_line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["xkd_line"];
            document.getElementById("nm_line").value = value["xnm_line"];
            $('#lineModal').modal('hide');
            validateKdLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kd_line = document.getElementById("kd_line").value.trim();
          if(kd_line === '') {
            document.getElementById("nm_line").value = "";
            $('#kd_line').focus();
          } else {
            $('#btn-display').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          document.getElementById("btn-display").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_line").value = "";
      document.getElementById("nm_line").value = "";
    }
  }

  $(document).ready(function(){

    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      "ordering": false, 
      'searching': false,
      "scrollX": true,
      "scrollY": "400px",
      "scrollCollapse": true,
      "paging": false
    });

    $('#btn-display').click( function () {
      var tahun = $('select[name="filter_tahun"]').val();
      var bulan = $('select[name="filter_bulan"]').val();
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var kd_line = document.getElementById("kd_line").value.trim();
      if(kd_plant !== "ALL" && kd_line !== "") {
        var urlRedirect = "{{ route('mtcttempacs.laporantempac', ['param','param2','param3','param4']) }}";
        urlRedirect = urlRedirect.replace('param4', window.btoa(kd_line));
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
        urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
        urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
        window.location.href = urlRedirect;
      } else {
        if(kd_plant === "ALL" && kd_line === "") {
          document.getElementById("kd_plant").focus();
        } else if(kd_plant === "ALL") {
          document.getElementById("kd_plant").focus();
        } else {
          document.getElementById("kd_line").focus();
        }
        swal("Plant & Line tidak boleh kosong!", "Perhatikan inputan anda!", "warning");
      }
    });
  });
</script>
@endsection