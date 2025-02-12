@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Permintaan Kalibrasi 
      <small>Alat Ukur</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('kalibrasi.index') }}"><i class="fa fa-files-o"></i>QA - Kalibrasi</a></li>
      <li class="active">Permintaan Kalibrasi</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Permintaan Kalibrasi</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        @permission('qa-alatukur-create')
        <p>
          <a class="btn btn-primary" href="{{ route('kalibrasi.create') }}"><span class="fa fa-plus"></span> Add Permintaan Kalibrasi</a>
        </p>
        @endpermission
        <div class="form-group{{ $errors->has('kd_plant') ? ' has-error' : '' }}">          
          <div class="col-sm-3">
            {!! Form::label('pt', 'PT (*)') !!}
            <div class="input-group">
              {!! Form::select('pt', ['IGP' => 'INTI GANDA PERDANA', 'GKD' => 'GEMALA KEMPA DAYA', 'AWI' => 'AKASHI WAHANA INDONESIA', 'AGI' => 'ASANO GEAR INDONESIA'], null, ['class'=>'form-control select2', 'id' => 'pt', 'required']) !!}         
              {!! $errors->first('pt', '<p class="help-block">:message</p>') !!}
            </div>
          </div>
          <div class="col-sm-2">
           {!! Form::label('kd_cust', 'Customer (F9)(*)') !!}      
           <div class="input-group">
            {!! Form::text('kd_cust', null, ['class'=>'form-control','placeholder' => 'Customer','onkeydown' => 'btnpopupCustClick(event)', 'onchange' => 'validateCust()','required']) !!} 
            <span class="input-group-btn">
              <button id="btnpopupCust" type="button" class="btn btn-info" data-toggle="modal" data-target="#custModal">
                <label class="glyphicon glyphicon-search"></label>
              </button>
            </span>
          </div>
          {!! $errors->first('kd_cust', '<p class="help-block">:message</p>') !!}
        </div>
        <div class="col-sm-4">
          {!! Form::label('nm_cust', 'Nama Customer') !!}      
          {!! Form::text('nm_cust', null, ['class'=>'form-control','placeholder' => 'Nama Customer', 'disabled'=>'']) !!} 
        </div>        
      </div>
      <!-- /.form-group -->
      <div class="form-group">

        <div class="col-sm-3">
          {!! Form::label('tahun', 'Tahun') !!}
          <div class="input-group">
            {!! Form::number('tahun', Carbon\Carbon::now()->year, ['class'=>'form-control']) !!}
            {!! $errors->first('tahun', '<p class="help-block">:message</p>') !!}
          </div>
        </div>
        <div class="col-sm-2">
          {!! Form::label('bulan', 'Bulan') !!}
          <div class="input-group">
            {!! Form::selectMonth('bulan', Carbon\Carbon::now()->month, ['class'=>'form-control']) !!}
            {!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}       
          </div>            
        </div>
        <div class="col-sm-2">
          {!! Form::label('kd_plant', 'Plant (*)') !!}
          <div class="input-group"> 
            <select id="kd_plant" name="kd_plant" class="form-control">
              <option value="" selected="selected">ALL</option>
              @foreach($plants->get() as $kode)
              <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
              @endforeach
            </select> 
          </div>
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
            <th style="width: 3%;">No Order</th>
            <th style="width: 3%;">Tanggal Order</th>
            <th style="width: 3%;">PT</th>
            <th style="width: 3%;">Customer</th>
            <th style="width: 3%;">Plant</th>
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
<!-- Popup Cust Modal -->
@include('eqa.kalibrasi.popup.custModal')
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("kd_plant").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
    $("#btnpopupCust").click(function(){
      popupCust();
    });
    
    var url = '{{ route('kalibrasi.dashboard') }}';
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
      "order": [[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      {data: null, name: null},
      {data: 'no_order', name: 'no_order'},
      {data: 'tgl_order', name: 'tgl_order'},
      {data: 'pt', name: 'pt'},
      {data: 'cust', name: 'cust'},
      {data: 'plant', name: 'plant'}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.plant = $('select[name="kd_plant"]').val();
      data.pt = $('select[name="pt"]').val();
      data.tahun = $('input[name="tahun"]').val();
      data.bulan = $('select[name="bulan"]').val();
      data.cust = $('input[name="kd_cust"]').val();
    });
    //firstLoad
    tableMaster.ajax.reload();
    
    $('#display').click( function () {
      tableMaster.ajax.reload();
    });    
  });

  //POPUP CUST
  function popupCust() {
    var myHeading = "<p>Popup Cust</p>";
    $("#custModalLabel").html(myHeading);

    var url = '{{ route('datatables.popupCustQa') }}';
    var lookupCust = $('#lookupCust').DataTable({
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
      { data: 'kd_cust', name: 'kd_cust'},
      { data: 'nm_cust', name: 'nm_cust'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        $('div.dataTables_filter input').focus();
        $('#lookupCust tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupCust.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_cust").value = value["kd_cust"];
            document.getElementById("nm_cust").value = value["nm_cust"];
            $('#custModal').modal('hide');
            validateCust();
          });
        });
        $('#custModal').on('hidden.bs.modal', function () {
          var kode = document.getElementById("kd_cust").value.trim();
          if(kode === '') {
            $('#kd_cust').focus();
          } else {
            $('#tahun').focus();
          }
        });
      },
    });     
  }

//VALIDASI CUST
function validateCust() {
  var kode = document.getElementById("kd_cust").value.trim();     
  if(kode !== '') {
    var url = '{{ route('datatables.validasiCustQa', ['param']) }}';
    url = url.replace('param', window.btoa(kode));
          //use ajax to run the check
          $.get(url, function(result){  
            if(result !== 'null'){
              result = JSON.parse(result);
              document.getElementById("nm_cust").value = result["nm_cust"];
              document.getElementById("tahun").focus();
            } else {
              document.getElementById("kd_cust").value = "";
              document.getElementById("nm_cust").value = "";
              document.getElementById("kd_cust").focus();
              swal("Customer tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
            }
          });
        } else {
          document.getElementById("kd_cust").value = "";
          document.getElementById("nm_cust").value = "";
        }   
      }

    </script>
    @endsection