@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Batal Permintaan Kalibrasi 
      <small>Alat Ukur</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><a href="{{ route('kalibrasi.index') }}"><i class="fa fa-files-o"></i>QA - Kalibrasi</a></li>
      <li class="active">Batal Permintaan Kalibrasi</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Batal Permintaan Kalibrasi</h3>
      </div>
      <!-- /.box-header -->
      
      <div class="box-body form-horizontal"> 
        
      <!-- /.form-group -->
      <div class="form-group">
        <div class="col-sm-2">
          {!! Form::label('bulan', 'Bulan') !!}
          <div class="input-group">
            {!! Form::selectMonth('bulan', Carbon\Carbon::now()->month, ['class'=>'form-control']) !!}
            {!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}       
          </div>            
        </div>
        <div class="col-sm-2">
          {!! Form::label('tahun', 'Tahun') !!}
          <div class="input-group">
            {!! Form::number('tahun', Carbon\Carbon::now()->year, ['class'=>'form-control']) !!}
            {!! $errors->first('tahun', '<p class="help-block">:message</p>') !!}
          </div>
        </div>        
        <div class="col-sm-3">
            {!! Form::label('status', 'Status') !!}
            <div class="input-group">
              {!! Form::select('status', array('ALL' => 'ALL', 'SUDAH' => 'SUDAH TARIK', 'BELUM' => 'BELUM TARIK', 'BATAL' => 'BATAL', 'OUTHOUSE' => 'OUTHOUSE'), 'ALL', ['class'=>'form-control']) !!}
              {!! $errors->first('status', '<p class="help-block">:message</p>') !!}      
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
              <th style="width: 5%;">No Order</th>
              <th style="width: 5%;">Tgl Order</th>
              <th style="width: 5%;">PT</th>
              <th style="width: 5%;">No Seri</th>
              <th style="width: 5%;">Nama Alat</th>
              <th style="width: 5%;">Tipe</th> 
              <th style="width: 5%;">Merk</th>
              <th style="width: 5%;">Status</th>
              <th style="width: 5%;">Keterangan Batal</th>
              <th style="width: 5%;">Action</th>                         
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

@include('eqa.kalibrasi.popup.batalModal')
<!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  document.getElementById("tahun").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  $(document).ready(function(){
        
    var url = '{{ route('kalibrasidet.dashboardtarik') }}';
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
      {data: 'no_seri', name: 'no_seri'},
      {data: 'nm_alat', name: 'nm_alat'},
      {data: 'nm_type', name: 'nm_type', searchable: 'false'},
      {data: 'nm_merk', name: 'nm_merk', searchable: 'false'}, 
      {data: 'status', name: 'status', orderable: 'false', searchable: 'false'},
      {data: 'ket_batal', name: 'ket_batal', orderable: 'false', searchable: 'false'},
      {data: 'action', name: 'action', orderable: 'false', searchable: 'false'}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tahun = $('input[name="tahun"]').val();
      data.bulan = $('select[name="bulan"]').val();
      data.status = $('select[name="status"]').val();
    });
    //firstLoad
    tableMaster.ajax.reload();
    
    $('#display').click( function () {
      tableMaster.ajax.reload();
    });  

    $('#btnsave').click( function () {
      savetarik();
    }); 
  });

  //POPUP DETAIL
  function popupBatal(noOrder, noSeri, st_batal, keterangan) {
    var myHeading = "<p>Keterangan Batal No Order : "+noOrder+" No Seri : "+ noSeri+"</p>";
    $("#batalModalLabel").html(myHeading);
    $( "#no_order" ).val(noOrder);
    $( "#no_seri" ).val(noSeri);
    $( "#st_batal" ).val(st_batal);
    $( "#keterangan" ).val(keterangan);
  }

  function savetarik() { 
        
            var token = document.getElementsByName('_token')[0].value.trim();
            var formData = new FormData();
            var no_order = document.getElementById("no_order").value.trim();
            var no_seri = document.getElementById("no_seri").value.trim();
            var st_batal = document.getElementById("st_batal").value.trim();
            var keterangan = document.getElementById("keterangan").value.trim();
            if(st_batal === '-'){
               st_batal = 'F';
            }

            formData.append('_method', 'POST');
            formData.append('_token', token);
            formData.append('no_order', no_order);
            formData.append('no_seri', no_seri);
            formData.append('st_batal', st_batal);
            formData.append('keterangan', keterangan);

            var url = "{{ route('kalibrasidet.bataltarik')}}";
            $("#loading").show();
            $.ajax({
              type     : 'POST',
              url      : url,
              dataType : 'json',
              data     : formData,
              cache: false,
              contentType: false,
              processData: false,
              success:function(data){
                $("#loading").hide();
                if(data.status === 'OK'){
                  swal("Rejected", data.message, "success");

                  oTable = $('#tblMaster').dataTable();
                  oTable.fnDraw();

                  var table = $('#tblMaster').DataTable();
                  table.ajax.reload(null, false);
                } else {
                  swal("Cancelled", data.message, "error");

                  oTable = $('#tblMaster').dataTable();
                  oTable.fnDraw();
                }
              }, error:function(){ 
                $("#loading").hide();
                swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");

                oTable = $('#tblMaster').dataTable();
                oTable.fnDraw();
              }
            });
          
    }

    </script>
@endsection