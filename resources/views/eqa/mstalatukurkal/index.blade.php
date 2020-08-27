@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Master Alat Ukur 
      <small>Alat Ukur</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('mstalatukurkal.index') }}"><i class="fa fa-files-o"></i>QA - Alat Ukur</a></li>
      <li class="active">Master Alat Ukur</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Master Alat Ukur</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal">
        @permission('qa-alatukur-create')
        <p>
          <a class="btn btn-primary" href="{{ route('mstalatukurkal.create') }}"><span class="fa fa-plus"></span> Add Master Alat Ukur</a>
        </p>
        @endpermission
        <div class="form-group{{ $errors->has('kd_plant') ? ' has-error' : '' }}">
          <div class="col-md-4">
          {!! Form::label('pt', 'PT (*)') !!}
            <div class="input-group">
              {!! Form::select('pt', ['ALL' => 'ALL', 'IGP' => 'INTI GANDA PERDANA', 'GKD' => 'GEMALA KEMPA DAYA', 'AWI' => 'AKASHI WAHANA INDONESIA', 'AGI' => 'ASANO GEAR INDONESIA'], null, ['class'=>'form-control select2', 'id' => 'pt', 'required']) !!} 
            </div>
          </div>
          <div class="col-md-2">
            {!! Form::label('kd_plant', 'Plant (*)') !!}
            <div class="input-group">
              @if (empty($tcalorder1->kd_plant))
              <select id="kd_plant" name="kd_plant" class="form-control select2">
               <option value="">-</option>         
               @foreach($plants->get() as $kode)
               <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>      
               @endforeach
             </select>
             @else
             {!! Form::select('kd_plant', array('' => '-', '1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4', 'A' => 'KIM-1A', 'B' => 'KIM-1B'), null, ['class'=>'form-control', 'disabled'=>'true']) !!}     
             {!! Form::hidden('kd_plant', null, ['class'=>'form-control','required', 'readonly' => '']) !!}
             @endif        
           </div>
         </div>
         <div class="col-md-2">
          {!! Form::label('kd_group', 'Group') !!}
          <div class="input-group">
            {!! Form::select('kd_group', ['A' => 'JAN', 'B' => 'FEB', 'C' => 'MAR', 'D' => 'APR', 'E' => 'MEI', 'F' => 'JUN', 'G' => 'JUL', 'H' => 'AGU', 'I' => 'SEP', 'J' => 'OKT', 'K' => 'NOV', 'L' => 'DES'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Group', 'id' => 'kd_group']) !!}            
            {!! $errors->first('kd_group', '<p class="help-block">:message</p>') !!}
          </div>
        </div>
        <div class="col-md-2">
          {!! Form::label('tipe', 'Tipe') !!}
          <div class="input-group">
            {!! Form::select('tipe', ['K' => 'KALIBRASI', 'V' => 'VERIFIKASI'], 'K', ['class'=>'form-control select2','placeholder' => 'Pilih Tipe', 'id' => 'tipe']) !!}            
            {!! $errors->first('tipe', '<p class="help-block">:message</p>') !!}
          </div>
        </div>
      </div>
      <!-- /.form-group -->
      <div class="form-group{{ $errors->has('kd_period') ? ' has-error' : '' }}">
        <div class="col-md-2">
          {!! Form::label('kd_period', 'Periode') !!}
          <div class="input-group">
            {!! Form::select('kd_period', ['1B' => '1 BULAN', '1H' => '1 HARI', '2B' => '2 BULAN', '3B' => '3 BULAN', '4B' => '4 BULAN', '6B' => '6 BULAN', '1T' => '1 TAHUN', '2T' => '2 TAHUN', '3T' => '3 TAHUN', '5T' => '5 TAHUN '], null, ['class'=>'form-control select2','placeholder' => 'Pilih Periode', 'id' => 'kd_period']) !!}            
            {!! $errors->first('kd_period', '<p class="help-block">:message</p>') !!}
          </div>
        </div>
        <div class="col-md-2">
         {!! Form::label('kd_au', 'Jenis (F9)') !!}  
         <div class="input-group">
          {!! Form::text('kd_au', null, ['class'=>'form-control','placeholder' => 'Jenis','onkeydown' => 'btnpopupJenisClick(event)', 'onchange' => 'validateJenis()']) !!} 
          <span class="input-group-btn">
            <button id="btnpopupJenis" type="button" class="btn btn-info" data-toggle="modal" data-target="#jenisModal">
              <label class="glyphicon glyphicon-search"></label>
            </button>
          </span>
        </div>   
        {!! $errors->first('kd_au', '<p class="help-block">:message</p>') !!}             
      </div>
      <div class="col-md-4">
        {!! Form::label('nm_au', 'Nama Jenis') !!}      
        {!! Form::text('nm_au', null, ['class'=>'form-control','placeholder' => 'Nama Jenis', 'disabled'=>'']) !!} 
      </div>         
    </div> 
    <!-- /.form-group -->
    <div class="form-group{{ $errors->has('posisi') ? ' has-error' : '' }}">
      <div class="col-md-2">
        {!! Form::label('posisi', 'Posisi') !!}
        <div class="input-group">
          {!! Form::select('posisi', ['REGULER' => 'REGULER', 'STOCK' => 'STOCK'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Posisi', 'id' => 'posisi']) !!}            
          {!! $errors->first('posisi', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
      <div class="col-md-3">
        {!! Form::label('kd_line', 'Line (F9)') !!}  
        <div class="input-group">
          {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line','onkeydown' => 'btnpopupLineClick(event)', 'onchange' => 'validateLine()']) !!}     
          <span class="input-group-btn">
            <button id="btnpopupLine" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
              <label class="glyphicon glyphicon-search"></label>
            </button>
          </span>
        </div>   
        {!! $errors->first('kd_line', '<p class="help-block">:message</p>') !!}
      </div>
      <div class="col-md-2">
        {!! Form::label('status_aktif', 'Status Aktif') !!}
        <div class="input-group">
          {!! Form::select('status_aktif', ['T' => 'Aktif', 'F' => 'Non Aktif'], null, ['class'=>'form-control select2','placeholder' => 'Pilih Status', 'id' => 'status_aktif']) !!}            
          {!! $errors->first('tipe', '<p class="help-block">:message</p>') !!}
        </div>
      </div>
    </div>

    <!-- /.form-group -->
    <div class="form-group">
      <div class="col-md-2">
        <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
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
          <th style="width: 3%;">ID</th>
          <th style="width: 3%;">Jenis Alat Ukur</th>
          <th style="width: 3%;">Spesificaton</th>
          <th style="width: 3%;">Toleransi</th>
          <th style="width: 3%;">Resolution</th>
          <th style="width: 3%;">Maker</th>
          <th style="width: 3%;">Tipe</th>
          <th style="width: 3%;">Line</th>
          <th style="width: 3%;">Station</th>
          <th style="width: 3%;">Period</th>
          <th style="width: 3%;">Group</th>
          <th style="width: 3%;">Tgl Next Cal</th>
          <th style="width: 3%;">Keterangan</th>
          <th style="width: 3%;">Model</th>
          <th style="width: 3%;">Titik Ukur</th>
          <th style="width: 3%;">Grade</th>
          <th style="width: 3%;">Thn</th>
          <th style="width: 3%;">Status</th>
          <th style="width: 3%;">Plant</th>
          <th style="width: 3%;">Posisi</th>
        </tr>
      </thead>
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- /.box -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("kd_plant").focus();
  function btnpopupLineClick(e) {
    if(e.keyCode == 120) {
      $('#btnpopupLine').click();
    }
  }

  function btnpopupJenisClick(e) {
    if(e.keyCode == 120) {
      $('#btnpopupJenis').click();
    }
  }   

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    $("#btnpopupLine").click(function(){
      popupLine();
    });

    $("#btnpopupJenis").click(function(){
      popupJenis();
    });

    var url = '{{ route('mstalatukurkal.dashboard') }}';
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
      "order": [[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      {data: null, name: null},
      {data: 'id_no', name: 'id_no'},
      {data: 'nm_au', name: 'nm_au'},
      {data: 'spec', name: 'spec', searchable: false},
      {data: 'toleransi', name: 'toleransi', searchable: false},        
      {data: 'res', name: 'res', searchable: false},
      {data: 'maker', name: 'maker', searchable: false},
      {data: 'tipe', name: 'tipe'},
      {data: 'kd_line', name: 'kd_line', searchable: false},
      {data: 'station', name: 'station', searchable: false},
      {data: 'kd_period', name: 'kd_period', searchable: false},
      {data: 'kd_group', name: 'kd_group', searchable: false},
      {data: 'tgl_next_cal', name: 'tgl_next_cal', searchable: false},
      {data: 'keterangan', name: 'keterangan', searchable: false},
      {data: 'model', name: 'model', searchable: false},
      {data: 'titik_ukur', name: 'titik_ukur', searchable: false},
      {data: 'grade', name: 'grade', searchable: false},
      {data: 'thn_perolehan', name: 'thn_perolehan', searchable: false},
      {data: 'status_aktif', name: 'status_aktif', searchable: false},
      {data: 'kd_plant', name: 'kd_plant', searchable: false},
      {data: 'posisi', name: 'posisi', searchable: false}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.pt = $('select[name="pt"]').val();
      data.plant = $('select[name="kd_plant"]').val();
      data.group = $('select[name="kd_group"]').val();
      data.tipe = $('select[name="tipe"]').val();
      data.period = $('select[name="kd_period"]').val();
      data.kd_au = $('input[name="kd_au"]').val();
      data.status = $('select[name="status_aktif"]').val();
      data.posisi = $('select[name="posisi"]').val();
      data.line = $('input[name="kd_line"]').val();
    });
    //firstLoad
    tableMaster.ajax.reload();

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });    
  });
  //POPUP LINE
  function popupLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupLineQcMst') }}';
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
      "order": [[0, 'asc']],
      columns: [
      { data: 'line', name: 'line'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        $('div.dataTables_filter input').focus();
        $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupLine.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_line").value = value["line"];
            $('#lineModal').modal('hide');
            validateLine();
          });
        });
        $('#lineModal').on('hidden.bs.modal', function () {
          var kode = document.getElementById("kd_line").value.trim();
          if(kode === '') {
            $('#kd_line').focus();
          } else {
            $('#display').focus();
          }
        });
      },
    });     
  }

  //VALIDASI LINE
  function validateLine() {
    var kode = document.getElementById("kd_line").value.trim();     
    if(kode !== '') {
      var url = '{{ route('datatables.validasiLineQcMst', ['param']) }}';
      url = url.replace('param', window.btoa(kode));
          //use ajax to run the check
          $.get(url, function(result){  
            if(result !== 'null'){
              result = JSON.parse(result);
              document.getElementById("kd_line").value = result["line"];
              document.getElementById("display").focus();
            } else {
              document.getElementById("kd_line").value = "";
              document.getElementById("kd_line").focus();
              swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
            }
          });
        } else {
          document.getElementById("kd_line").value = "";
        }   
      }

  //POPUP JENIS
  function popupJenis() {
    var myHeading = "<p>Popup Jenis</p>";
    $("#lineModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupJenisQc') }}';
    var lookupJenis = $('#lookupJenis').DataTable({
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      "pagingType": "numbers",
      ajax: url,
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      responsive: true,
      "order": [[0, 'asc']],
      columns: [
      { data: 'kd_au', name: 'kd_au'},
      { data: 'nm_au', name: 'nm_au'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        $('div.dataTables_filter input').focus();
        $('#lookupJenis tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupJenis.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_au").value = value["kd_au"];
            document.getElementById("nm_au").value = value["nm_au"];
            $('#jenisModal').modal('hide');
            validateJenis();
          });
        });
        $('#jenisModal').on('hidden.bs.modal', function () {
          var kode = document.getElementById("kd_au").value.trim();
          if(kode === '') {
            $('#kd_au').focus();
          } else {
            $('#status_aktif').focus();
          }
        });
      },
    });     
  }

  //VALIDASI JENIS
  function validateJenis() {
    var kode = document.getElementById("kd_au").value.trim();     
    if(kode !== '') {
      var url = '{{ route('datatables.validasiJenisQc', ['param']) }}';
      url = url.replace('param', window.btoa(kode));
            //use ajax to run the check
            $.get(url, function(result){  
              if(result !== 'null'){
                result = JSON.parse(result);
                document.getElementById("kd_au").value = result["kd_au"];
                document.getElementById("nm_au").value = result["nm_au"];
                document.getElementById("status_aktif").focus();
              } else {
                document.getElementById("kd_au").value = "";
                document.getElementById("nm_au").value = "";
                document.getElementById("kd_au").focus();
                swal("Jenis tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
              }
            });
          } else {
            document.getElementById("kd_au").value = "";
            document.getElementById("nm_au").value = "";
          }   
        }

        function btnpopupJenisClick(e) {
      if(e.keyCode == 120) { //F9
        $('#btnpopupJenis').click();
      } else if(e.keyCode == 9) { //TAB
        e.preventDefault();
        document.getElementById('btnpopupJenis').focus();
      }
    }

    function btnpopupLineClick(e) {
      if(e.keyCode == 120) { //F9
        $('#btnpopupLine').click();
      } else if(e.keyCode == 9) { //TAB
        e.preventDefault();
        document.getElementById('btnpopupLine').focus();
      }
    }
  </script>
  @endsection