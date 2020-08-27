@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CMS
        <small>Daftar CMS</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li class="active"><i class="fa fa-files-o"></i> Daftar CMS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    	@include('layouts._flash')
    	<div class="row">
	        <div class="col-md-12">
	          <div class="box box-primary">
              <div class="box-header">
                <p> 
                  <a class="btn btn-primary" href="{{ route('mtctdftmslhs.index') }}">
                    <span class="fa fa-book"></span> Daftar Masalah
                  </a>
                  &nbsp;&nbsp;
                  <a class="btn btn-primary" href="{{ route('mtctdftmslhs.all') }}">
                    <span class="fa fa-print"></span> Laporan Daftar Masalah
                  </a>
                  &nbsp;&nbsp;
                  <a class="btn btn-primary" href="{{ route('mtctpmss.index') }}">
                    <span class="fa fa-book"></span> Daily Activity Zone
                  </a>
                </p>
              </div>
              <!-- /.box-header -->
              <div class="box-body form-horizontal">
                <div class="form-group">
                  <div class="col-sm-2">
                    {!! Form::label('tgl_awal', 'Tanggal Awal') !!}
                    {!! Form::date('tgl_awal', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl_awal']) !!}
                  </div>
                  <div class="col-sm-2">
                    {!! Form::label('tgl_akhir', 'Tanggal Akhir') !!}
                    {!! Form::date('tgl_akhir', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Akhir', 'id' => 'tgl_akhir']) !!}
                  </div>
                  <div class="col-sm-2">
                    {!! Form::label('lok_pt', 'Plant') !!}
                    <select size="1" id="lok_pt" name="lok_pt" class="form-control select2" onchange="changeKdPlant()">
                      <option value="-" selected="selected">ALL</option>
                      @foreach($plant->get() as $kode)
                        <option value="{{$kode->kd_plant}}">{{$kode->nm_plant}}</option>
                      @endforeach
                    </select>
                  </div>
                  <div class="col-sm-4">
                    {!! Form::label('lbldep', 'Departemen') !!}
                    <select name="filter_dep" aria-controls="filter_status" class="form-control select2">
                      <option value="ALL" selected="selected">ALL</option>
                      @foreach($departement->get() as $kode)
                        <option value="{{$kode->kd_dep}}">{{$kode->desc_dep}} - {{$kode->kd_dep}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <div class="col-sm-2">
                    {!! Form::label('kd_line', 'Line (F9)') !!}
                    <div class="input-group">
                      {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                      <span class="input-group-btn">
                        <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                          <span class="glyphicon glyphicon-search"></span>
                        </button>
                      </span>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    {!! Form::label('nm_line', 'Nama Line') !!}
                    {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
                  </div>
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                  <div class="col-sm-2">
                    {!! Form::label('filter_status', 'Status') !!}
                    {!! Form::select('filter_status', ['ALL' => 'ALL', 'F' => 'Belum Submit', 'T' => 'Sudah Submit', 'PIC' => 'Approve PIC', 'FM' => 'Approve Foreman', 'RJT' => 'Reject', 'LP' => 'Sudah LP'], null, ['class'=>'form-control select2', 'id' => 'filter_status']) !!}
                  </div>
                  <div class="col-sm-2">
                    {!! Form::label('lblusername2', 'Action') !!}
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
			                <th style="width: 10%;">No. DM</th>
			                <th style="width: 5%;">Tgl</th>
                      <th style="width: 20%;">Line</th>
			                <th style="width: 20%;">Mesin</th>
			                <th>Problem</th>
                      <th>Site</th>
                      <th>Plant</th>
                      <th>No. PI</th>
                      <th>No. LP</th>
                      <th>Departemen</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
                      <th>Submit</th>
                      <th>Approve PIC</th>
                      <th>Approve Foreman</th>
                      <th>Reject</th>
                      <th>Tgl Plan Pengerjaan</th>
                      <th>Tgl Plan CMS</th>
			                <th style="width: 5%;">Action</th>
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

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('filter_status').focus();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var lok_pt = document.getElementById('lok_pt').value.trim();
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(lok_pt));
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
            $('#filter_status').focus();
          }
        });
      },
    });
  }

  function validateKdLine() {
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_line !== '') {
      var lok_pt = document.getElementById('lok_pt').value.trim();
      var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(lok_pt));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];
        } else {
          document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          document.getElementById("kd_line").focus();
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
    
    var url = '{{ route('dashboard.mtctdftmslhs', 'param') }}';
    url = url.replace('param', window.btoa("T"));

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
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
      	{data: null, name: null},
        {data: 'no_dm', name: 'no_dm'},
        {data: 'tgl_dm', name: 'tgl_dm'},
        {data: 'line', name: 'line'},
        {data: 'mesin', name: 'mesin'},
        {data: 'ket_prob', name: 'ket_prob'},
        {data: 'kd_site', name: 'kd_site', className: "none"},
        {data: 'kd_plant', name: 'kd_plant', className: "none"},
        {data: 'no_pi', name: 'no_pi', className: "none"},
        {data: 'no_lp', name: 'no_lp', className: "none", orderable: false, searchable: false},
        {data: 'kd_dep', name: 'kd_dep', className: "none", orderable: false, searchable: false},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'submit_npk', name: 'submit_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_fm_npk', name: 'apr_fm_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_npk', name: 'rjt_npk', className: "none", orderable: false, searchable: false},
        {data: 'tgl_plan_mulai', name: 'tgl_plan_mulai', className: "none", orderable: false, searchable: false},
        {data: 'tgl_plan_cms', name: 'tgl_plan_cms', className: "none", orderable: false, searchable: false}, 
        {data: 'action', name: 'action', orderable: false, searchable: false}
	    ]
    });

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.tgl_awal = $('input[name="tgl_awal"]').val();
      data.tgl_akhir = $('input[name="tgl_akhir"]').val();
      data.lok_pt = $('select[name="lok_pt"]').val();
      data.kd_dep = $('select[name="filter_dep"]').val();
      data.kd_line = $('input[name="kd_line"]').val();
      data.status = $('select[name="filter_status"]').val();
    });

    $('#display').click( function () {
      tableMaster.ajax.reload();
    });

    //$('#display').click();
  });
</script>
@endsection