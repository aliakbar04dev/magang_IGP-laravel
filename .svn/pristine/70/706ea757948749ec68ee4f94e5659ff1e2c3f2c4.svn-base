@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PPC - CYCLE TIME
        <small>PPC - CYCLE TIME</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-truck"></i> PPC - REPORT</li>
        <li class="active"><i class="fa fa-files-o"></i> CYCLE TIME</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">CYCLE TIME</h3>
        </div>
        <!-- /.box-header -->
        
    		<div class="box-body form-horizontal">
    		  <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('filter_site', 'Site') !!}
              {!! Form::select('filter_site', ['IGPJ' => 'IGP - JAKARTA', 'IGPK' => 'IGP - KARAWANG'], null, ['class'=>'form-control select2', 'id' => 'filter_site', 'onchange' => 'changeKdSite()']) !!}
            </div>
            <div class="col-sm-2">
            {!! Form::label('filter_plant', 'Plant') !!}
              {!! Form::select('filter_plant', ['1' => 'IGP-1', '2' => 'IGP-2', '3' => 'IGP-3', '4' => 'IGP-4'], null, ['class'=>'form-control select2', 'id' => 'filter_plant']) !!}
            </div>
    		  </div>
    		  <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Bulan') !!}
              <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
                class="form-control select2">
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
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('filter_tahun', 'Tahun') !!}
              <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
              class="form-control select2">
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                  @if ($i == \Carbon\Carbon::now()->format('Y'))
                    <option value={{ $i }} selected="selected">{{ $i }}</option>
                  @else
                    <option value={{ $i }}>{{ $i }}</option>
                  @endif
                @endfor
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
            @permission(['ppc-cycletime-upload'])
              <div class="col-sm-2">
                {!! Form::label('lblupload', 'Upload') !!}
                <button id="btn-upload" type="button" class="form-control btn btn-success" data-toggle="tooltip" data-placement="top" title="Upload">Upload</button>
              </div>
            @endpermission
          </div>
          <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th rowspan="2" style="width: 1%;">No</th>
                <th rowspan="2">Line</th>
                <th rowspan="2">No. Proses</th>
                <th rowspan="2">Kode Mesin</th>
                <th rowspan="2">Model</th>
                <th colspan="2" style="text-align:center;">CT</th>
                <th rowspan="2" style="width: 5%;">Varian</th>
                <th rowspan="2" style="width: 5%;">Status</th>
              </tr>
              <tr>
                <th style="width: 5%;">ENG</th>
                <th style="width: 5%;">PPC</th>
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

  document.getElementById("filter_site").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function changeKdSite() {
    var kd_site = document.getElementById("filter_site").value;
    $('#filter_plant').children('option').remove();
    if(kd_site === "IGPK") {
      $("#filter_plant").append('<option value="A">KIM-1A</option>');
      $("#filter_plant").append('<option value="B">KIM-1B</option>');
    } else if(kd_site === "IGPJ") {
      $("#filter_plant").append('<option value="1">IGP-1</option>');
      $("#filter_plant").append('<option value="2">IGP-2</option>');
      $("#filter_plant").append('<option value="3">IGP-3</option>');
      $("#filter_plant").append('<option value="4">IGP-4</option>');
    }
  }

  $(document).ready(function(){

    $("#btn-upload").click(function(){
      swal({
        title: 'Select File Excel',
        html:
        'Untuk Template Upload Cycle Time, ' +
        '<a target="_blank" href="{{ route('vwtctperiods.template') }}">Download di sini</a> ',
        input: 'file',
        inputAttributes: {
          // accept: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'
          accept: 'application/vnd.ms-excel'
        }
      }).then(function (file) {
        if(file == null) {
          swal("Tidak ada file yang dipilih!", "", "warning");
        } else {
          var kd_site = $('select[name="filter_site"]').val();
          var kd_plant = $('select[name="filter_plant"]').val();
          var tahun = $('select[name="filter_tahun"]').val();
          var bulan = $('select[name="filter_bulan"]').val();

          var url = '{{ route('vwtctperiods.cekdata', ['param', 'param2', 'param3', 'param4', 'param5']) }}';
          url = url.replace('param5', window.btoa("PPC"));
          url = url.replace('param4', window.btoa(bulan));
          url = url.replace('param3', window.btoa(tahun));
          url = url.replace('param2', window.btoa(kd_plant));
          url = url.replace('param', window.btoa(kd_site));
          //use ajax to run the check
          $.get(url, function(result){  
            if(result !== 'null'){
              var msg = 'Sudah ada data! Anda yakin Upload Ulang Cycle Time?';
              var txt = 'Site: ' + kd_site + ', Plant: ' + kd_plant + ', Tahun: ' + tahun + ', Bulan: ' + bulan;
              //additional input validations can be done hear
              swal({
                title: msg,
                text: txt,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, upload it!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                reverseButtons: false,
                focusCancel: true,
              }).then(function () {
                //file.name == "photo.png"
                //file.type == "image/png"
                //file.size == 300821
                // var validExts = new Array(".xlsx", ".xls");
                var validExts = new Array(".xls");
                var fileExt = file.name;
                fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                if (validExts.indexOf(fileExt) < 0) {
                  swal("Invalid file selected, valid files are of " + validExts.toString() + " types.", "", "warning");
                } else {
                  var token = document.getElementsByName('_token')[0].value.trim();

                  var formData = new FormData();
                  formData.append('_method', 'POST');
                  formData.append('_token', token);
                  formData.append('file', file);
                  formData.append('kd_site', kd_site);
                  formData.append('kd_plant', kd_plant);
                  formData.append('tahun', tahun);
                  formData.append('bulan', bulan);
                  formData.append('mode', "PPC");

                  var url = "{{ route('vwtctperiods.upload') }}";
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
                        swal(data.message, "", "success");
                      } else {
                        swal(data.message, "", "error");
                      }
                    }, error:function(){ 
                      $("#loading").hide();
                      swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
                    }
                  });
                }
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
            } else {
              var msg = 'Anda yakin Upload Cycle Time?';
              var txt = 'Site: ' + kd_site + ', Plant: ' + kd_plant + ', Tahun: ' + tahun + ', Bulan: ' + bulan;
              //additional input validations can be done hear
              swal({
                title: msg,
                text: txt,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, upload it!',
                cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
                allowOutsideClick: true,
                allowEscapeKey: true,
                allowEnterKey: true,
                reverseButtons: false,
                focusCancel: true,
              }).then(function () {
                //file.name == "photo.png"
                //file.type == "image/png"
                //file.size == 300821
                // var validExts = new Array(".xlsx", ".xls");
                var validExts = new Array(".xls");
                var fileExt = file.name;
                fileExt = fileExt.substring(fileExt.lastIndexOf('.'));
                if (validExts.indexOf(fileExt) < 0) {
                  swal("Invalid file selected, valid files are of " + validExts.toString() + " types.", "", "warning");
                } else {
                  var token = document.getElementsByName('_token')[0].value.trim();

                  var formData = new FormData();
                  formData.append('_method', 'POST');
                  formData.append('_token', token);
                  formData.append('file', file);
                  formData.append('kd_site', kd_site);
                  formData.append('kd_plant', kd_plant);
                  formData.append('tahun', tahun);
                  formData.append('bulan', bulan);
                  formData.append('mode', "PPC");

                  var url = "{{ route('vwtctperiods.upload') }}";
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
                        swal(data.message, "", "success");
                      } else {
                        swal(data.message, "", "error");
                      }
                    }, error:function(){ 
                      $("#loading").hide();
                      swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
                    }
                  });
                }
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
          });
        }
      })
    });

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
      "order": [[1, 'asc'],[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: "{{ route('vwtctperiods.dashboardeng') }}",
      columns: [
        {data: null, name: null, className: "dt-center"}, 
        {data: 'kd_line', name: 'kd_line'}, 
        {data: 'no_proses', name: 'no_proses'}, 
        {data: 'kd_mesin', name: 'kd_mesin'}, 
        {data: 'kd_model', name: 'kd_model'}, 
        {data: 'ct_eng', name: 'ct_eng', className: "dt-right"}, 
        {data: 'ct_ppc', name: 'ct_ppc', className: "dt-right"}, 
        {data: 'ct_var', name: 'ct_var', className: "dt-right"}, 
        {data: 'status', name: 'status', className: "dt-center", orderable: false, searchable: false}
      ],
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.kd_site = $('select[name="filter_site"]').val();
      data.kd_plant = $('select[name="filter_plant"]').val();
      data.tahun = $('select[name="filter_tahun"]').val();
      data.bulan = $('select[name="filter_bulan"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload()
    });

    // $('#display').click();
  });
</script>
@endsection