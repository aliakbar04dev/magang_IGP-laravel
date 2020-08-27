@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Master Konstanta 
      <small>Konstanta</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('konstanta.index') }}"><i class="fa fa-files-o"></i>QA - Konstanta</a></li>
      <li class="active">Master Konstanta</li> 
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Master Konstanta</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        @permission('qa-kalibrasi-create')
        <p>
          <a class="btn btn-primary" href="{{ route('konstanta.create') }}"><span class="fa fa-plus"></span> Add Konstanta</a>
        </p>
        @endpermission        
        <!-- /.form-group -->
        <div class="form-group">
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
      <div class="form-group">
        <div class="col-sm-2">
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
            <th style="width: 3%;">Kode Konstanta</th>
            <th style="width: 3%;">Jenis</th>              
            <th style="width: 3%;">Fungsi</th>
            <th style="width: 3%;">Rentang</th>
            <th style="width: 3%;">Resolusi</th>             
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
<!-- Popup Jenis Modal -->
@include('eqa.konstanta.popup.jenisModal')
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("kd_au").focus();
  $(document).ready(function(){
    $("#btnpopupJenis").click(function(){
      popupJenis();
    });
    
    var url = '{{ route('konstanta.dashboard') }}';
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
      {data: 'kode_kons', name: 'kode_kons'},
      {data: 'jenis', name: 'jenis'},
      {data: 'fungsi', name: 'fungsi'},
      {data: 'rentang', name: 'rentang'},
      {data: 'resolusi', name: 'resolusi'}   
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.kd_au = $('input[name="kd_au"]').val();
    });
    //firstLoad
    //tableMaster.ajax.reload();

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });    
  }); 

  //POPUP JENIS
  function popupJenis() {
    var myHeading = "<p>Popup Jenis</p>";
    $("#jenisModalLabel").html(myHeading);

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
            $('#display').focus();
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
                document.getElementById("display").focus();
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

  </script>
  @endsection