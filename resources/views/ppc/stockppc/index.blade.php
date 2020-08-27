@extends('layouts.app')
@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Inventory Level
      <small>{{ $label }}</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
      <li><i class="fa fa-truck"></i> PPC JKT - Inventory Level</li>
      <li class="active"><i class="fa fa-files-o"></i> {{ $label }}</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">{{ $label }}</h3> 
      </div>
      <!-- /.box-header -->

      {!! Form::hidden('param_tahun', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_tahun']) !!}
      {!! Form::hidden('param_bulan', null, ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'param_bulan']) !!}

      <div class="box-body form-horizontal">
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
        </div>
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-4">
            {!! Form::label('lblwhs', 'Warehouse') !!}
            <select id="filter_whs" name="filter_whs" aria-controls="filter_status" class="form-control select2">
              @foreach($filter_whs->get() as $baan_whs)
                <option value="{{ $baan_whs->kd_cwar }}">{{ $baan_whs->kd_cwar }} - {{ $baan_whs->nm_dsca }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-sm-4">
            {!! Form::label('lblstatus', 'Status') !!}
            <select id="filter_stok" multiple="multiple" name="filter_stok" aria-controls="filter_status" class="form-control select2">
              <option value="OVER" >OVER</option>
              <option value="NORMAL" >NORMAL</option>
              <option value="WARNING" >WARNING</option>
              <option value="CRITICAL" >CRITICAL</option>
            </select>
          </div>
        </div>
        <!-- /.form-group -->
        <div class="form-group">
          <div class="col-sm-2">
            <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
          </div>
          <div class="col-sm-2">
            <img src="../../images/blue.png" alt="X" data-toggle="tooltip" data-placement="top" title="OVER">OVER
          </div>
          <div class="col-sm-2">
            <img src="../../images/green.png" alt="X" data-toggle="tooltip" data-placement="top" title="NORMAL">NORMAL
          </div>
          <div class="col-sm-2">
            <img src="../../images/yellow.png" alt="X" data-toggle="tooltip" data-placement="top" title="WARNING">WARNING
          </div>
          <div class="col-sm-2">
            <img src="../../images/red.png" alt="X" data-toggle="tooltip" data-placement="top" title="CRITICAL">CRITICAL
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
              <th style="width: 7%;">Supplier</th>
              <th style="width: 15%;">Partno</th>
              <th>Description</th>
              <th style="width: 7%;">WHS</th>
              <th style="width: 5%;">Prod/Day</th>
              <th style="width: 5%;">Min</th>
              <th style="width: 5%;">Max</th>
              <th style="width: 5%;">Stock</th>
              <th style="width: 5%;">Status</th>
              <th style="width: 7%;">Stock Age(Hour)</th>
              <th style="width: 7%;">Location</th>
              <th>Ket. CM</th>
              <th>Last Sync</th>
            </tr>
          </thead>
        </table>
      </div>
      <!-- /.box-body -->

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">
                  <p>
                    <label id="info-detail">History</label>
                  </p>
                </h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                  <thead>
                    <th style="width: 1%;">No</th>
                    <th>Ket. CM</th>
                    <th style="width: 15%;">Tanggal</th>
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
      </div>
      <!-- /.box-body -->

      <div class="box-body">
        <div class="row">
          <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title"><p id="info-detail2">Grafik</p></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <table id="tblGrafik" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th style='white-space: nowrap;min-width: 150px;overflow: auto;text-overflow: clip;;text-align: center'>Keterangan</th>
                      @for($i = 1; $i <= 31; $i++)
                        <th style='text-align: center'>{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}</th>
                      @endfor
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

  document.getElementById("filter_whs").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function updatecm(whse, item, cm)
  {
    swal({
      title: 'Input Keterangan CM \n(Warehouse: ' + whse + ', Part No : ' + item + ')',
      html: 
        '<textarea id="swal-input" class="form-control" maxlength="100" rows="3" cols="20" placeholder="(Max. 100 Karakter)" style="resize:vertical">' + cm + '</textarea>',
      showCancelButton: true,
      preConfirm: function () {
        return new Promise(function (resolve, reject) {
          if ($('#swal-input').val()) {
            if($('#swal-input').val().length > 100) {
              reject('Keterangan Max 100 Karakter!')
            } else {
              resolve([
                $('#swal-input').val()
              ])
            }
          } else {
            reject('Keterangan tidak boleh kosong!')
          }
        })
      }
    }).then(function (result) {
      if(result[0] == null || result[0] == "") {
        result[0] = "-";
      }
      var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('stockohigps.updatecm')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method   : 'POST',
          // menambah csrf token dari Laravel
          _token     : token,
          whse       : window.btoa(whse),
          item       : window.btoa(item),
          keterangan : result[0],
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Updated", data.message, "success");
            var table = $('#tblMaster').DataTable();
            table.ajax.reload(null, false);
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          $("#loading").hide();
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
    }).catch(swal.noop)
  }

  $(document).ready(function(){

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
      "order": [[3, 'asc'],[1, 'asc']],
      processing: true, 
      "oLanguage": {
        "sLengthMenu": "Show _MENU_ entries<label class='form-horizontal' style='display: inline-block; margin-left:20px;'><font color='red'>Stock akhir ini tidak berpengaruh dengan periode.</font></label>",
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: "{{ route('stockohigps.dashboardinventorylevel') }}",
      columns: [
        {data: null, name: null},
        {data: 'bpid', name: 'bpid'},
        {data: 'item', name: 'item'},
        {data: 'nm_item', name: 'nm_item'},
        {data: 'whse', name: 'whse'},
        {data: 'day', name: 'day', className: "dt-right"},
        {data: 'qty_min', name: 'qty_min', className: "dt-right"},
        {data: 'qty_max', name: 'qty_max', className: "dt-right"},
        {data: 'qty', name: 'qty', className: "dt-right"},
        {data: 'st_stock', name: 'st_stock', className: "dt-center"},     
        {data: 'stok_age', name: 'stok_age', className: "dt-right"},         
        {data: 'lokasi', name: 'lokasi'},
        {data: 'cm', name: 'cm', className: "none"},
        {data: 'dtcrea', name: 'dtcrea', className: "none"}
      ],
    });

    $('#tblMaster tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail").innerHTML = 'History';
        document.getElementById("info-detail2").innerHTML = 'Grafik';
        initTable(window.btoa('-'), window.btoa('-'));
      } else {
        tableMaster.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableMaster.rows().count() > 0) {
          var index = tableMaster.row('.selected').index();
          var part_no = tableMaster.cell(index, 2).data();
          var part_name = tableMaster.cell(index, 3).data();
          var whse = tableMaster.cell(index, 4).data();
          var info = "Warehouse: " + whse + ", Part: " + part_no + " - " + part_name;

          var param_tahun = document.getElementById("param_tahun").value.trim();
          if(param_tahun == null || param_tahun == "") {
            param_tahun = "-";
          }
          var param_bulan = document.getElementById("param_bulan").value.trim();
          if(param_bulan == null || param_bulan == "") {
            param_bulan = "-";
          }
          var regex = /(<([^>]+)>)/ig;

          var url_grafik = '{{ route('stockohigps.datagrafik', ['param', 'param2', 'param3', 'param4']) }}';
          url_grafik = url_grafik.replace('param4', window.btoa(part_no.replace(regex, "")));
          url_grafik = url_grafik.replace('param3', window.btoa(whse.replace(regex, "")));
          url_grafik = url_grafik.replace('param2', window.btoa(param_bulan));
          url_grafik = url_grafik.replace('param', window.btoa(param_tahun));
          var link = "<a target='_blank' href='"+url_grafik+"'>Show Grafik</a>";

          var info2 = "Tahun: " + param_tahun + ", Bulan: " + param_bulan + ", Warehouse: " + whse + ", Part: " + part_no + " - " + part_name + ". " + link;

          document.getElementById("info-detail").innerHTML = 'History (' + info + ')';
          document.getElementById("info-detail2").innerHTML = 'Grafik (' + info2 + ')';
          
          initTable(window.btoa(whse.replace(regex, "")), window.btoa(part_no.replace(regex, "")));
        }
      }
    });

    var urlDetail = '{{ route('stockohigps.history', ['param', 'param2']) }}';
    urlDetail = urlDetail.replace('param2', "-");
    urlDetail = urlDetail.replace('param', "-");
    var tableDetail = $('#tblDetail').DataTable({
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
      "order": [[2, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: urlDetail,
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'ket_cm', name: 'ket_cm'},
        {data: 'dtcrea', name: 'dtcrea', className: "dt-center"}
      ],
    });

    var urlGrafik = '{{ route('stockohigps.dashboardgrafik', ['param', 'param2', 'param3', 'param4']) }}';
    urlGrafik = urlGrafik.replace('param4', window.btoa("-"));
    urlGrafik = urlGrafik.replace('param3', window.btoa("-"));
    urlGrafik = urlGrafik.replace('param2', window.btoa("-"));
    urlGrafik = urlGrafik.replace('param', window.btoa("-"));
    var tableGrafik = $('#tblGrafik').DataTable({
      "searching": false,
      "ordering": false,
      "paging": false,
      "scrollX": true,
      "scrollY": "300px",
      "scrollCollapse": true,
      // responsive: true,
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // serverSide: true,
      ajax: urlGrafik, 
      columns: [
        {data: 'st_ket', name: 'st_ket', orderable: false, searchable: false},
        @for ($i = 1; $i <= 31; $i++)
          @if($i == 31)
            {data: 't{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}', name: 't{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}', className: 'dt-right', orderable: false, searchable: false}
          @else 
            {data: 't{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}', name: 't{{ str_pad($i, 2, "0", STR_PAD_LEFT) }}', className: 'dt-right', orderable: false, searchable: false},
          @endif
        @endfor
      ], 
    });

    function initTable(whse, item) {
      var urlDetail = '{{ route('stockohigps.history', ['param', 'param2']) }}';
      urlDetail = urlDetail.replace('param2', item);
      urlDetail = urlDetail.replace('param', whse);
      tableDetail.ajax.url(urlDetail).load();

      var param_tahun = document.getElementById("param_tahun").value.trim();
      if(param_tahun == null || param_tahun == "") {
        param_tahun = "-";
      }
      var param_bulan = document.getElementById("param_bulan").value.trim();
      if(param_bulan == null || param_bulan == "") {
        param_bulan = "-";
      }

      var urlGrafik = '{{ route('stockohigps.dashboardgrafik', ['param', 'param2', 'param3', 'param4']) }}';
      urlGrafik = urlGrafik.replace('param4', item);
      urlGrafik = urlGrafik.replace('param3', whse);
      urlGrafik = urlGrafik.replace('param2', window.btoa(param_bulan));
      urlGrafik = urlGrafik.replace('param', window.btoa(param_tahun));
      tableGrafik.ajax.url(urlGrafik).load();
    }

    $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
      data.whs = $('select[name="filter_whs"]').val();
      data.stok = $('select[name="filter_stok"]').val();
    });

    $('#display').click( function () {
      document.getElementById("param_tahun").value = $('select[name="filter_tahun"]').val();
      document.getElementById("param_bulan").value = $('select[name="filter_bulan"]').val();
      tableMaster.ajax.reload( function ( json ) {
        if(tableMaster.rows().count() > 0) {
          $('#tblMaster tbody tr:eq(0)').click(); 
        } else {
          initTable(window.btoa('-'), window.btoa('-'));
        }
      });
    });

    //$('#display').click();
  });
</script>
@endsection