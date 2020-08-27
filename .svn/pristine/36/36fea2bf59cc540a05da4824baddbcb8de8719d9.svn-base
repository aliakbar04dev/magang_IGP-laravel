@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        LCH Alat Angkut
        <small>Lembar Check Harian Alat Angkut</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> LCH Alat Angkut</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      {!! Form::open(['url' => route('mtctlchforklif1s.store'),
      'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal', 'id'=>'form_id']) !!}
        @if (isset($tgl))
          {!! Form::hidden('param_tgl', $tgl, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tgl']) !!}
        @else 
          {!! Form::hidden('param_tgl', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tgl']) !!}
        @endif

        @if (isset($shift))
          {!! Form::hidden('param_shift', $shift, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_shift']) !!}
        @else 
          {!! Form::hidden('param_shift', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_shift']) !!}
        @endif

        @if (isset($kd_unit))
          {!! Form::hidden('param_kd_unit', $kd_unit, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_kd_unit']) !!}
        @else 
          {!! Form::hidden('param_kd_unit', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_kd_unit']) !!}
        @endif

        @if (isset($mtct_lch_forklif2s))
          {!! Form::hidden('jml_row', $mtct_lch_forklif2s->get()->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
        @else 
          {!! Form::hidden('jml_row', 0, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_row']) !!}
        @endif

        <div class="box box-primary">
          <div class="box-body form-horizontal">
            <div class="form-group">
              <div class="col-sm-3">
                {!! Form::label('filter_tgl', 'Tanggal') !!}
                @if (isset($tgl))
                  {!! Form::date('filter_tgl', \Carbon\Carbon::createFromFormat('Ymd', $tgl), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl']) !!}
                @else 
                  {!! Form::date('filter_tgl', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'filter_tgl']) !!}
                @endif
              </div>
              <div class="col-sm-2">
                {!! Form::label('filter_shift', 'Shift') !!}
                <select id="filter_shift" name="filter_shift" class="form-control select2">
                  @if (isset($shift))
                    <option value="1" @if ("1" == $shift) selected="selected" @endif>1</option>
                    <option value="2" @if ("2" == $shift) selected="selected" @endif>2</option>
                    <option value="3" @if ("3" == $shift) selected="selected" @endif>3</option>
                  @else 
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  @endif
                </select>
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group">
              <div class="col-sm-3">
                {!! Form::label('kd_unit', 'Kode Unit (F9)') !!}
                <div class="input-group">
                  @if (isset($kd_unit))
                    {!! Form::text('kd_unit', $kd_unit, ['class'=>'form-control','placeholder' => 'Kode Unit', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdUnit(event)', 'onchange' => 'validateKdUnit()', 'id' => 'kd_unit']) !!}
                  @else 
                    {!! Form::text('kd_unit', null, ['class'=>'form-control','placeholder' => 'Kode Unit', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdUnit(event)', 'onchange' => 'validateKdUnit()', 'id' => 'kd_unit']) !!}
                  @endif
                  <span class="input-group-btn">
                    <button id="btnpopupunit" type="button" class="btn btn-info" data-toggle="modal" data-target="#unitModal">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </span>
                </div>
              </div>
              <div class="col-sm-5">
                {!! Form::label('nm_unit', 'Nama Unit') !!}
                @if (isset($nm_unit))
                  {!! Form::text('nm_unit', $nm_unit, ['class'=>'form-control','placeholder' => 'Nama Unit', 'disabled'=>'', 'id' => 'nm_unit']) !!}
                @else 
                  {!! Form::text('nm_unit', null, ['class'=>'form-control','placeholder' => 'Nama Unit', 'disabled'=>'', 'id' => 'nm_unit']) !!}
                @endif
              </div>
              <div class="col-sm-2">
                {!! Form::label('lblusername2', 'Action') !!}
                <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
              </div>
            </div>
            <!-- /.form-group -->
            <div class="form-group" id="form-group-foto" name="form-group-foto">
              <div class="col-sm-8">
                <div class="box box-primary collapsed-box">
                  <div class="box-header with-border">
                    <h3 class="box-title" id="boxtitle">Foto</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <center>
                      @if (isset($lok_pict))
                        <img src="{{ $lok_pict }}" class="img-rounded img-responsive" alt="File Not Found" id="lok_pict">
                      @else 
                        <img src="" class="img-rounded img-responsive" alt="File Not Found" id="lok_pict">
                      @endif
                    </center>
                    <p class="text-muted text-center"></p>
                  </div>
                  <!-- ./box-body -->
                </div>
                <!-- /.box -->
              </div>
            </div>
            <!-- /.form-group -->
          </div>
          <!-- /.box-body -->
          @if (isset($mtct_lch_forklif2s))
            <div class="box-body">
              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <caption style="display: table-caption;"><strong>Tanggal: {{ \Carbon\Carbon::createFromFormat('Ymd', $tgl)->format('d M Y') }}, Shift: {{ $shift }}, Unit: {{ $kd_unit }} - {{ $nm_unit }}</strong></center></caption>
                <thead>
                  <tr>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Item Check</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Ketentuan</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Cara</th>
                    <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Alat</th>
                    <th style="text-align: center;width: 10%;">Status</th>
                    <th style="width: 10%;">Uraian Masalah</th>
                    <th style="width: 15%;">Picture (jpeg,png,jpg)</th>
                    <th>Picture</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($mtct_lch_forklif2s->get() as $data)
                    <tr>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                        <input type="hidden" id="row-{{ $loop->iteration }}-mtct_lch_forklif1_id" name="row-{{ $loop->iteration }}-mtct_lch_forklif1_id" class="form-control" readonly="readonly" value="{{ base64_encode($data->mtct_lch_forklif1_id) }}">
                        <input type="hidden" id="row-{{ $loop->iteration }}-no_is" name="row-{{ $loop->iteration }}-no_is" class="form-control" readonly="readonly" value="{{ base64_encode($data->no_is) }}">
                        <input type="hidden" id="row-{{ $loop->iteration }}-nm_is" name="row-{{ $loop->iteration }}-nm_is" class="form-control" readonly="readonly" value="{{ $data->nm_is }}">
                        {{ $data->nm_is }}
                      </td>
                      <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                        {{ $data->ketentuan }}
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                        {{ $data->metode }}
                      </td>
                      <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                        {{ $data->alat }}
                      </td>
                      <td style="text-align: center">
                        @if($data->nm_is != null)
                          @if (Auth::user()->can(['mtc-lchforklift-create','mtc-lchforklift-delete']))
                            <select id="row-{{ $loop->iteration }}-st_cek" name="row-{{ $loop->iteration }}-st_cek" onchange="changeStatus(this)" class="form-control select2" size="2" required>
                              <option value="T" @if($data->st_cek === "T") selected="selected" @endif>OK</option>
                              <option value="F" @if($data->st_cek !== "T") selected="selected" @endif>NG</option>
                            </select>
                          @else 
                            @if($data->st_cek === "T")
                              OK
                            @else 
                              NG
                            @endif
                          @endif
                        @endif
                      </td>
                      <td>
                        @if($data->nm_is != null)
                          @if (Auth::user()->can(['mtc-lchforklift-create','mtc-lchforklift-delete']))
                            <textarea id="row-{{ $loop->iteration }}-uraian_masalah" name="row-{{ $loop->iteration }}-uraian_masalah" rows="2" cols="30" maxlength="200" style="resize:vertical" @if($data->st_cek === "T") disabled="disabled" @else required @endif>{{ $data->uraian_masalah }}</textarea>
                          @else 
                            {{ $data->uraian_masalah }}
                          @endif
                        @endif
                      </td>
                      <td>
                        @if($data->nm_is != null)
                          @if (Auth::user()->can(['mtc-lchforklift-create','mtc-lchforklift-delete']))
                            <input id="row-{{ $loop->iteration }}-pict_masalah" name="row-{{ $loop->iteration }}-pict_masalah" type="file" @if($data->st_cek === "T") disabled="disabled" @else @if($data->pict_masalah == null) required @endif @endif>
                          @else 
                            -
                          @endif
                        @endif
                      </td>
                      <td>
                        @if($data->nm_is != null)
                          @if($data->pict_masalah != null)
                            <p>
                              <img src="{{ $mtct_lch_forklif1->pict($data->pict_masalah) }}" alt="File Not Found" class="img-rounded img-responsive">
                              {{-- <a class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus File" href="{{ route('mtctlchforklif1s.deleteimage', [base64_encode($data->mtct_lch_forklif1_id), base64_encode($data->no_is)]) }}"><span class="glyphicon glyphicon-remove"></span></a> --}}
                            </p>
                          @endif
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
            @if ($mtct_lch_forklif2s->get()->count() > 0)
              <div class="box-footer">
                <div class="form-group">
                  <div class="col-sm-4">
                    <div class="box box-primary {{ $mtct_lch_forklif1->pict_kiri != null ? 'collapsed-box' : ''}}">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="boxtitle">Foto dari sisi kiri</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-12 {{ $errors->has('pict_kiri') ? ' has-error' : '' }}">
                            {!! Form::label('pict_kiri', 'Picture Kiri (jpeg,png,jpg)') !!}
                            @if (!empty($mtct_lch_forklif1->pict_kiri))
                              {!! Form::file('pict_kiri', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                              <p>
                                <img src="{{ $mtct_lch_forklif1->pict($mtct_lch_forklif1->pict_kiri) }}" alt="File Not Found" class="img-rounded img-responsive">
                              </p>
                            @else 
                              {!! Form::file('pict_kiri', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png', 'required']) !!}
                            @endif
                            {!! $errors->first('pict_kiri', '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                      </div>
                      <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <div class="col-sm-4">
                    <div class="box box-primary {{ $mtct_lch_forklif1->pict_belakang != null ? 'collapsed-box' : ''}}">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="boxtitle">Foto dari sisi belakang</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-12 {{ $errors->has('pict_belakang') ? ' has-error' : '' }}">
                            {!! Form::label('pict_belakang', 'Picture Belakang (jpeg,png,jpg)') !!}
                            @if (!empty($mtct_lch_forklif1->pict_belakang))
                              {!! Form::file('pict_belakang', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                              <p>
                                <img src="{{ $mtct_lch_forklif1->pict($mtct_lch_forklif1->pict_belakang) }}" alt="File Not Found" class="img-rounded img-responsive">
                              </p>
                            @else 
                              {!! Form::file('pict_belakang', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png', 'required']) !!}
                            @endif
                            {!! $errors->first('pict_belakang', '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                      </div>
                      <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <div class="col-sm-4">
                    <div class="box box-primary {{ $mtct_lch_forklif1->pict_kanan != null ? 'collapsed-box' : ''}}">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="boxtitle">Foto dari sisi kanan</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <div class="row form-group">
                          <div class="col-sm-12 {{ $errors->has('pict_kanan') ? ' has-error' : '' }}">
                            {!! Form::label('pict_kanan', 'Picture Kanan (jpeg,png,jpg)') !!}
                            @if (!empty($mtct_lch_forklif1->pict_kanan))
                              {!! Form::file('pict_kanan', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png']) !!}
                              <p>
                                <img src="{{ $mtct_lch_forklif1->pict($mtct_lch_forklif1->pict_kanan) }}" alt="File Not Found" class="img-rounded img-responsive">
                              </p>
                            @else 
                              {!! Form::file('pict_kanan', ['class'=>'form-control', 'style' => 'resize:vertical', 'accept' => '.jpg,.jpeg,.png', 'required']) !!}
                            @endif
                            {!! $errors->first('pict_kanan', '<p class="help-block">:message</p>') !!}
                          </div>
                        </div>
                        <!-- /.form-group -->
                      </div>
                      <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <div class="col-sm-3 {{ $errors->has('st_cuci') ? ' has-error' : '' }}">
                    {!! Form::label('st_cuci', 'Cuci (*)') !!}
                    {!! Form::select('st_cuci', ['F' => 'TIDAK','T' => 'YA' ], $mtct_lch_forklif1->st_cuci, ['class'=>'form-control select2', 'id' => 'st_cuci']) !!}
                    {!! $errors->first('st_cuci', '<p class="help-block">:message</p>') !!}
                  </div>
                  <div class="col-sm-3 {{ $errors->has('st_cuci') ? ' has-error' : '' }}">
                      {!! Form::label('st_unit', 'Status Unit (*)') !!}
                      {!! Form::select('st_unit', ['NORMAL' => 'NORMAL', 'OVERHOUL' => 'OVERHOUL', 'UNIT OFF' => 'UNIT OFF'], $mtct_lch_forklif1->st_unit, ['class'=>'form-control select2',  'id' => 'st_unit', 'onchange' => 'refreshRequired()']) !!}
                      {!! $errors->first('st_unit', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                
                <!-- /.form-group -->
                @if (Auth::user()->can(['mtc-lchforklift-create','mtc-lchforklift-delete']))
                  {!! Form::submit('Save Data', ['class'=>'btn btn-primary', 'id' => 'btn-save']) !!}
                  &nbsp;&nbsp;
                  <p class="help-block pull-right has-error">{!! Form::label('info', '(*) tidak boleh kosong', ['style'=>'color:red']) !!}</p>
                @endif
              </div>
              <!-- /.box-footer -->
            @endif
          @endif
        </div>
        <!-- /.box -->
      {!! Form::close() !!}

      <!-- Modal Unit -->
      @include('mtc.lchforklift.popup.unitModal')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  document.getElementById("filter_tgl").focus();

  var kd_unit = document.getElementById("kd_unit").value.trim();
  if(kd_unit === "") {
    $('#form-group-foto').removeAttr('style');
    $('#form-group-foto').attr('style', 'display: none;');
    $('#lok_pict').removeAttr('src');
  } else {
    $('#form-group-foto').removeAttr('style');
    @if (isset($lok_pict))
      $('#lok_pict').attr('src', '{{ $lok_pict }}');
    @else 
      $('#lok_pict').attr('src', null);
    @endif
  }

  @if (isset($mtct_lch_forklif2s))
    @if ($mtct_lch_forklif2s->get()->count() > 0)
      function refreshRequired() {
        var st_unit = $("select[name='st_unit']").val();
        if(st_unit === "UNIT OFF"){
          $("#pict_kiri").removeAttr('required');
          $("#pict_belakang").removeAttr('required');
          $("#pict_kanan").removeAttr('required');
        } else {
          @if (empty($mtct_lch_forklif1->pict_kiri))
            $("#pict_kiri").attr('required', 'required');
          @endif
          @if (empty($mtct_lch_forklif1->pict_belakang))
            $("#pict_belakang").attr('required', 'required');
          @endif
          @if (empty($mtct_lch_forklif1->pict_kanan))
            $("#pict_kanan").attr('required', 'required');
          @endif
        }
      }

      refreshRequired();
    @endif
  @endif

  //Initialize Select2 Elements
  $(".select2").select2();

  $('#form_id').submit(function (e, params) {
    var localParams = params || {};
    if (!localParams.send) {
      e.preventDefault();

      var table = $('#tblMaster').DataTable();
      table.search('').columns().search('').draw();
      counter = table.rows().count();
      document.getElementById("jml_row").value = counter;
      
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

  function keyPressedKdUnit(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupunit').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('btn-display').focus();
    }
  }

  function popupKdUnit() {
    var myHeading = "<p>Popup Unit</p>";
    $("#unitModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupUnits') }}';
    var lookupUnit = $('#lookupUnit').DataTable({
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
        { data: 'kd_mesin', name: 'kd_mesin'},
        { data: 'nm_mesin', name: 'nm_mesin'},
        { data: 'maker', name: 'maker'},
        { data: 'mdl_type', name: 'mdl_type'},
        { data: 'mfd_thn', name: 'mfd_thn'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupUnit tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupUnit.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_unit").value = value["kd_mesin"];
            document.getElementById("nm_unit").value = value["nm_mesin"];
            $('#unitModal').modal('hide');
            validateKdUnit();
          });
        });
        $('#unitModal').on('hidden.bs.modal', function () {
          var kd_unit = document.getElementById("kd_unit").value.trim();
          if(kd_unit === '') {
            document.getElementById("nm_unit").value = "";
            $('#form-group-foto').removeAttr('style');
            $('#form-group-foto').attr('style', 'display: none;');
            $('#lok_pict').removeAttr('src');
            $('#kd_unit').focus();
          } else {
            $('#btn-display').focus();
          }
        });
      },
    });
  }

  function validateKdUnit() {
    var kd_unit = document.getElementById("kd_unit").value.trim();
    if(kd_unit !== '') {
      var url = '{{ route('datatables.validasiUnit', 'param') }}';
      url = url.replace('param', window.btoa(kd_unit));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_unit").value = result["kd_mesin"];
          document.getElementById("nm_unit").value = result["nm_mesin"];
          $('#form-group-foto').removeAttr('style');
          $('#lok_pict').attr('src', result["lok_pict"]);
        } else {
          document.getElementById("kd_unit").value = "";
          document.getElementById("nm_unit").value = "";
          $('#form-group-foto').removeAttr('style');
          $('#form-group-foto').attr('style', 'display: none;');
          $('#lok_pict').removeAttr('src');
          document.getElementById("btn-display").focus();
          swal("Unit tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("kd_unit").value = "";
      document.getElementById("nm_unit").value = "";
      $('#form-group-foto').removeAttr('style');
      $('#form-group-foto').attr('style', 'display: none;');
      $('#lok_pict').removeAttr('src');
    }
  }

  $(document).ready(function(){

    $("#btnpopupunit").click(function(){
      popupKdUnit();
    });

    var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // "responsive": true,
      "ordering": false, 
      "searching": false,
      "scrollX": true,
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false, 
      columns: [
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false},
        {orderable: false, searchable: false}, 
        {orderable: false, searchable: false}
      ],
    });

    $('#btn-display').click( function () {
      var var_tgl = document.getElementById("filter_tgl").value.trim();
      var shift = document.getElementById('filter_shift').value.trim();
      var kd_unit = document.getElementById('kd_unit').value.trim();
      if(var_tgl !== "" && shift !== "" && kd_unit !== "") {
        var date = new Date(var_tgl);
        var tahun = date.getFullYear();
        var bulan = date.getMonth() + 1;
        if(bulan < 10) {
          bulan = "0" + bulan;
        }
        var tgl = date.getDate();
        if(tgl < 10) {
          tgl = "0" + tgl;
        }

        var param = tahun + "" + bulan + "" + tgl;
        var urlRedirect = "{{ route('mtctlchforklif1s.lch', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_unit));
        urlRedirect = urlRedirect.replace('param2', window.btoa(shift));
        urlRedirect = urlRedirect.replace('param', window.btoa(param));
        window.location.href = urlRedirect;
      } else {
        swal("Tanggal, Shift & Kode Unit tidak boleh kosong!", "Perhatikan inputan anda!", "warning");
      }
    });
  });

  function changeStatus(ths) {
    var row = ths.name.replace('st_cek', '');
    var uraian_masalah = row + "uraian_masalah";
    var id_uraian_masalah = "#" + uraian_masalah;
    var pict_masalah = row + "pict_masalah";
    var id_pict_masalah = "#" + pict_masalah;
    var st_cek = $("select[name='"+ths.name+"']").val();
    if(st_cek === "T"){
      $(id_uraian_masalah).removeAttr('required');
      $(id_uraian_masalah).attr('disabled', 'disabled');
      document.getElementById(uraian_masalah).value = null;
      $(id_pict_masalah).removeAttr('required');
      $(id_pict_masalah).attr('disabled', 'disabled');
      document.getElementById(pict_masalah).value = null;
    } else {
      $(id_uraian_masalah).attr('required', 'required');
      $(id_uraian_masalah).removeAttr('disabled');
      $(id_pict_masalah).attr('required', 'required');
      $(id_pict_masalah).removeAttr('disabled');
      document.getElementById(uraian_masalah).focus();
    }
  }
</script>
@endsection