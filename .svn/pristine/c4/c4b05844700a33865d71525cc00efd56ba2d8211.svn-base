@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Alat Ukur
      <small>Riwayat Alat Ukur</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-files-o"></i> QC - Alat Ukur</li>
      <li class="active"><i class="fa fa-files-o"></i> Riwayat Alat Ukur</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title">Riwayat Alat Ukur</h3>
          </div>
          <div class="box-body form-horizontal">
            @permission('qc-alatukur-create')
            <button class="btn btn-primary" id="btnAdd" type="button" class="btn btn-info"><span class="fa fa-plus"></span> Add Riwayat Alat Ukur</button>
            @endpermission
            <div class="col-md-12">
              <div class="col-md-2">
                {!! Form::label('plant', 'Plant') !!}
                @if (empty($kdPlant))
                {!! Form::select('plant', array('1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4', 'A' => 'KIM-1A', 'B' => 'KIM-1B'), '1', ['class'=>'form-control']) !!}
                @else
                {!! Form::select('plant', array('1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4', 'A' => 'KIM-1A', 'B' => 'KIM-1B'), $kdPlant, ['class'=>'form-control']) !!}
                @endif
              </div>
              <div class="col-md-2">
               {!! Form::label('serial', 'No Serial (F9)') !!}  
               <div class="input-group">
                @if (empty($noSerial))
                {!! Form::text('serial', null, ['class'=>'form-control','placeholder' => 'Serial','onkeydown' => 'btnpopupSerialClick(event)', 'onchange' => 'validateSerial();refreshTable();']) !!}
                @else
                {!! Form::text('serial', $noSerial, ['class'=>'form-control','placeholder' => 'Serial','onkeydown' => 'btnpopupSerialClick(event)', 'onchange' => 'validateSerial();refreshTable();']) !!}
                @endif     
                <span class="input-group-btn">
                  <button id="btnpopupSerial" type="button" class="btn btn-info" data-toggle="modal" data-target="#serialModal">
                    <label class="glyphicon glyphicon-search"></label>
                  </button>
                </span>
              </div>   
              {!! $errors->first('serial', '<p class="help-block">:message</p>') !!}
              <!-- Popup Serial Modal -->
              @include('eqc.histalatukur.popup.serialModal')                
            </div>
            <div class="col-md-4">
              {!! Form::label('nm_alat', 'Nama Alat') !!}
              {!! Form::text('nm_alat', null, ['class'=>'form-control','readonly'=>'']) !!}
            </div>
            <div class="col-md-2">
              {!! Form::label('maker', 'Maker') !!}
              {!! Form::text('maker', null, ['class'=>'form-control','readonly'=>'']) !!}
            </div>                   
          </div>
          <div class="col-md-12">
            <div class="col-md-2">
              {!! Form::label('tipe', 'Tipe') !!}
              {!! Form::text('tipe', null, ['class'=>'form-control','readonly'=>'']) !!}
            </div>   
            <div class="col-md-2">
              {!! Form::label('line', 'Line') !!}
              {!! Form::text('line', null, ['class'=>'form-control','readonly'=>'']) !!}
            </div>  
            <div class="col-md-2">
              {!! Form::label('resolution', 'Resolution') !!}
              {!! Form::text('resolution', null, ['class'=>'form-control','readonly'=>'']) !!}
            </div>
            <div class="col-md-2">
              {!! Form::label('calibration', 'Calibration Freq') !!}
              {!! Form::text('calibration', null, ['class'=>'form-control','readonly'=>'']) !!}
            </div>
            <div class="col-md-2">
              {!! Form::label('groups', 'Group') !!}
              {!! Form::text('groups', null, ['class'=>'form-control','readonly'=>'']) !!}
            </div>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No Order</th>
                <th>Tgl Order</th>
                <th>No Sertifikat</th>
                <th>OK</th>
                <th>Tgl Kalibrasi Selanjutnya</th>
                <th>Keterangan</th>
                <th>Tgl Act Kal</th>
                <th>No Sertifikat Act</th>
                <th style="width: 5%;" >Action</th>
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

 function btnpopupSerialClick(e) {
  if(e.keyCode == 120) {
    $('#btnpopupSerial').click();
  }
}

$(document).ready(function(){  
  refreshTable();
  $("#btnpopupSerial").click(function(){
    var plant = document.getElementById("plant").value.trim();     
    if(plant !== '') {
      popupSerial(plant);
    }else{
      refreshTable();
    }
  });
  $("#btnAdd").click(function(){
    var serial = document.getElementById("serial").value.trim();
    var plant = document.getElementById("plant").value.trim();      
    if(serial !== '') {
      var url = '{{ route('histalatukur.create', ['param', 'param1']) }}';
      url = url.replace('param', window.btoa(serial));
      url = url.replace('param1', window.btoa(plant));
      window.open(url,"_self")
    }else{
      swal("Serial harus diisi!", "Serial harus diisi untuk menambah data.", "error");
    }
  });    
});

function refreshTable(){
  var param = document.getElementById("plant").value;
  var param1 = document.getElementById("serial").value;
  if(param1 !== '') {
    var url = '{{ route('histalatukur.dashboard', ['param', 'param1']) }}';
    url = url.replace('param', window.btoa(param));
    url = url.replace('param1', window.btoa(param1));
    
    var tblMaster = $('#tblMaster').DataTable({   

      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      { data: 'no_order', name: 'no_order'},
      { data: 'tgl_update', name: 'tgl_update'},
      { data: 'no_sertifikat', name: 'no_sertifikat'},
      { data: 'st_ok', name: 'st_ok'},
      { data: 'tgl_next_kal', name: 'tgl_next_kal'},
      { data: 'nm_ket_update', name: 'nm_ket_update'},
      { data: 'tgl_kal_act', name: 'tgl_kal_act'},
      { data: 'no_order_act', name: 'no_order_act'},
      { data: 'action', name: 'action', className: "dt-center", orderable: false, searchable: false}
      ],
      "bDestroy": true,            
    });
    $('#tblMaster').DataTable().ajax.reload(null, false);
  }
}
//POPUP SERIAL
function popupSerial(plant) {
  var myHeading = "<p>Popup Serial</p>";
  $("#serialModalLabel").html(myHeading);

  var url = '{{ route('datatables.popupSerialQc', ['param']) }}';
  url = url.replace('param', window.btoa(plant));
  var lookupSerial = $('#lookupSerial').DataTable({
    processing: true, 
    "oLanguage": {
      'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    }, 
    serverSide: true,
    "pagingType": "numbers",
    ajax: url,
    "aLengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
    responsive: true,
    columns: [
    { data: 'id_no', name: 'id_no'},
    { data: 'nm_alat', name: 'nm_alat'},
    { data: 'maker', name: 'maker'},
    { data: 'spec', name: 'spec'},
    { data: 'res', name: 'res'},
    { data: 'titik_ukur', name: 'titik_ukur'},
    { data: 'keterangan', name: 'keterangan'}
    ],
    "bDestroy": true,
    "initComplete": function(settings, json) {
      $('div.dataTables_filter input').focus();
      $('#lookupSerial tbody').on( 'dblclick', 'tr', function () {
        var dataArr = [];
        var rows = $(this);
        var rowData = lookupSerial.rows(rows).data();
        $.each($(rowData),function(key,value){
          document.getElementById("serial").value = value["id_no"];
          $('#serialModal').modal('hide');
          validateSerial();
        });
      });
      $('#serialModal').on('hidden.bs.modal', function () {
        var kode = document.getElementById("serial").value.trim();
        if(kode === '') {
          $('#serial').focus();
        } else {
          $('#serial').focus();
        }
      });
    },
  });
}

  //VALIDASI SERIAL
  function validateSerial() {
    var kode = document.getElementById("serial").value.trim();     
    if(kode !== '') {
      var url = '{{ route('datatables.validasiSerialQc', ['param']) }}';
      url = url.replace('param', window.btoa(kode));
          //use ajax to run the check
          $.get(url, function(result){  
            if(result !== 'null'){
              result = JSON.parse(result);
              document.getElementById("nm_alat").value = result["nm_alat"];
              document.getElementById("maker").value = result["maker"];
              document.getElementById("tipe").value = result["tipe"];
              document.getElementById("line").value = result["line"];
              document.getElementById("resolution").value = result["res"];
              document.getElementById("calibration").value = result["frekwensi"];
              document.getElementById("groups").value = result["groups"];
            } else {
              document.getElementById("serial").value = "";
              document.getElementById("serial").focus();
              swal("Serial tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
            }
            refreshTable();
          });
        } else {
          document.getElementById("serial").value = "";
        }   
      }

    </script>
    @endsection