@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Pengisian Oli
        <small>Pengisian Oli</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Pengisian Oli</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::open(['url' => route('mtctolis.store'),
      'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
        @if (isset($tahun))
          {!! Form::hidden('param_tahun', $tahun, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tahun']) !!}
        @else 
          {!! Form::hidden('param_tahun', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tahun']) !!}
        @endif

        @if (isset($bulan))
          {!! Form::hidden('param_bulan', $bulan, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_bulan']) !!}
        @else 
          {!! Form::hidden('param_bulan', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_bulan']) !!}
        @endif

        @if (isset($kd_site))
          {!! Form::hidden('param_kd_site', $kd_site, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_kd_site']) !!}
        @else 
          {!! Form::hidden('param_kd_site', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_kd_site']) !!}
        @endif

        @if (isset($kd_plant))
          {!! Form::hidden('param_kd_plant', $kd_plant, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_kd_plant']) !!}
        @else 
          {!! Form::hidden('param_kd_plant', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_kd_plant']) !!}
        @endif

        @if (isset($tgl))
          {!! Form::hidden('param_tgl', $tgl, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tgl']) !!}
        @else 
          {!! Form::hidden('param_tgl', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tgl']) !!}
        @endif

        @if (isset($mtctolis))
          {!! Form::hidden('jml_row', $mtctolis->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
        @else 
          {!! Form::hidden('jml_row', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
        @endif

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
                <select size="1" id="kd_plant" name="kd_plant" class="form-control select2">
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
              <div class="col-sm-2">
                {!! Form::label('filter_tgl', 'Tanggal') !!}
                <select id="filter_tgl" name="filter_tgl" aria-controls="filter_status" 
                class="form-control select2">
                  @if (isset($tgl))
                    @for($i = 1; $i <= 31; $i++)
                      <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}" @if (str_pad($i, 2, "0", STR_PAD_LEFT) == $tgl) selected="selected" @endif>{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</option>
                    @endfor
                  @else 
                    @for($i = 1; $i <= 31; $i++)
                      <option value="{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}" @if (str_pad($i, 2, "0", STR_PAD_LEFT) == \Carbon\Carbon::now()->format('d')) selected="selected" @endif>{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</option>
                    @endfor
                  @endif
                </select>
              </div>
              <div class="col-sm-2">
                {!! Form::label('lblusername2', 'Action') !!}
                <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.box-body -->
          @if (isset($mtctolis))
            <div class="box-body">
              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <caption style="display: table-caption;"><strong>Tahun: {{ $tahun }}, Bulan: {{ $bulan }}, Plant: {{ $kd_plant }}, Tanggal: {{ $tgl }}</strong></center></caption>
                <thead>
                  <tr>
                    <th>No</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Mesin</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Line</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Jenis Oli</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Deskripsi</th>
                    <th style="text-align: center">Satuan</th>
                    <th style="text-align: center">Tanggal {{ $tgl }}</th>
                    <th style="text-align: center">Jenis</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mtctolis->get() as $data)
                    <tr>
                      <td style="text-align: center;">{{ $loop->iteration }}</td>
                      <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                        <input type="hidden" id="row-{{ $loop->iteration }}-kd_mesin" name="row-{{ $loop->iteration }}-kd_mesin" class="form-control" readonly="readonly" value="{{ $data->kd_mesin }}">
                        {{ $data->kd_mesin }}
                      </td>
                      <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                        <input type="hidden" id="row-{{ $loop->iteration }}-kd_line" name="row-{{ $loop->iteration }}-kd_line" class="form-control" readonly="readonly" value="{{ $data->kd_line }}">
                        {{ $data->kd_line }}
                      </td>
                      <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">{{ $data->jns_oli }}</td>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                        <input type="hidden" id="row-{{ $loop->iteration }}-kd_brg" name="row-{{ $loop->iteration }}-kd_brg" class="form-control" readonly="readonly" value="{{ $data->kd_brg }}">
                        @if ($data->nm_alias != null)
                          {{ $data->nm_alias }} # {{ $data->kd_brg }}
                        @else
                          {{ $data->nm_brg }} # {{ $data->kd_brg }}
                        @endif
                      </td>
                      <td style="text-align: center">
                        LTR
                      </td>
                      <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                        <input type='number' id="row-{{ $loop->iteration }}-tgl" name="row-{{ $loop->iteration }}-tgl" class="form-control" value="{{ $data->tgl }}" style='width: 7em;text-align:right;' min=0 max=9999999999.999 step='any' @if (!Auth::user()->can(['mtc-oli-create','mtc-oli-delete'])) disabled="" @endif>
                      </td>
                      <td>
                        <select id="row-{{ $loop->iteration }}-jns" name="row-{{ $loop->iteration }}-jns" class="form-control" size="1" @if (!Auth::user()->can(['mtc-oli-create','mtc-oli-delete'])) disabled="" @endif>
                          <option value="TOPUP" @if($data->jns === "TOPUP") selected="selected" @endif>TOPUP</option>
                          <option value="PREVENTIVE" @if($data->jns === "PREVENTIVE") selected="selected" @endif>PREVENTIVE</option>
                        </select>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            @if ($mtctolis->get()->count() > 0 && Auth::user()->can(['mtc-oli-create','mtc-oli-delete']))
              <div class="box-footer">
                {!! Form::submit('Save Data', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                &nbsp;&nbsp;
                <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
              </div>
              <!-- /.box-footer -->
            @endif
          @endif
        </div>
        <!-- /.box -->
      {!! Form::close() !!}
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

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();

      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();
      
      var valid = 'T';
      if(valid === 'T') {
        //additional input validations can be done hear
        swal({
          title: 'Are you sure?',
          text: '',
          type: 'question',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, save it!',
          cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
          allowOutsideClick: true,
          allowEscapeKey: true,
          allowEnterKey: true,
          reverseButtons: false,
          focusCancel: false,
        }).then(function () {
          $(e.currentTarget).trigger(e.type, { 'send': true });
        }, function (dismiss) {
          // dismiss can be 'cancel', 'overlay',
          // 'close', and 'timer'
          if (dismiss === 'cancel') {
            // swal(
            //   'Cancelled',
            //   'Your imaginary file is safe :)',
            //   'error'
            // )
          }
        })
      }
    }
  });

  $(document).ready(function(){

    var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      "ordering": false, 
      // 'searching': false,
      "scrollX": true,
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false
    });

    $('#btn-display').click( function () {
      var tahun = $('select[name="filter_tahun"]').val();
      var bulan = $('select[name="filter_bulan"]').val();
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var tgl = $('select[name="filter_tgl"]').val();
      if(kd_plant !== "ALL") {
        var urlRedirect = "{{ route('mtctolis.pengisianoli', ['param','param2','param3','param4']) }}";
        urlRedirect = urlRedirect.replace('param4', window.btoa(tgl));
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
        urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
        urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
        window.location.href = urlRedirect;
      } else {
        document.getElementById("kd_plant").focus();
        swal("Plant tidak boleh kosong!", "Perhatikan inputan anda!", "warning");
      }
    });
  });
</script>
@endsection