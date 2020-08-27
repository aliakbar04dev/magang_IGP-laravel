@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Bill of Material
        <small>Bill of Material</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Master</li>
        <li class="active"><i class="fa fa-files-o"></i> BOM</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
              {!! Form::label('kd_cust', 'Customer (F9)') !!}
              <div class="input-group">
                @if (isset($kd_cust))
                  {!! Form::text('kd_cust', $kd_cust, ['class'=>'form-control','placeholder' => 'Customer', 'onkeydown' => 'keyPressedKdCust(event)', 'onchange' => 'validateKdCust()', 'id' => 'kd_cust']) !!}
                @else 
                  {!! Form::text('kd_cust', null, ['class'=>'form-control','placeholder' => 'Customer', 'onkeydown' => 'keyPressedKdCust(event)', 'onchange' => 'validateKdCust()', 'id' => 'kd_cust']) !!}
                @endif
                <span class="input-group-btn">
                  <button id="btnpopupcust" type="button" class="btn btn-info" data-toggle="modal" data-target="#custModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-4">
              {!! Form::label('nm_cust', 'Nama Customer') !!}
              @if (isset($nm_cust))
                {!! Form::text('nm_cust', $nm_cust, ['class'=>'form-control','placeholder' => 'Nama Customer', 'disabled'=>'', 'id' => 'nm_cust']) !!}
              @else 
                {!! Form::text('nm_cust', null, ['class'=>'form-control','placeholder' => 'Nama Customer', 'disabled'=>'', 'id' => 'nm_cust']) !!}
              @endif
            </div>
            <div class="col-sm-2">
              {!! Form::label('status', 'Status (F9)') !!}
              <div class="input-group">
                @if (isset($status))
                  {!! Form::text('status', $status, ['class'=>'form-control','placeholder' => 'Status', 'onkeydown' => 'keyPressedStatus(event)', 'onchange' => 'validateStatus()', 'id' => 'status']) !!}
                @else 
                  {!! Form::text('status', null, ['class'=>'form-control','placeholder' => 'Status', 'onkeydown' => 'keyPressedStatus(event)', 'onchange' => 'validateStatus()', 'id' => 'status']) !!}
                @endif
                <span class="input-group-btn">
                  <button id="btnpopupstatus" type="button" class="btn btn-info" data-toggle="modal" data-target="#statusModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('part_no', 'Part No Parent (F9)') !!}
              <div class="input-group">
                @if (isset($part_no))
                  {!! Form::text('part_no', $part_no, ['class'=>'form-control','placeholder' => 'Part No Parent', 'onkeydown' => 'keyPressedPart(event)', 'onchange' => 'validatePart()', 'id' => 'part_no']) !!}
                @else 
                  {!! Form::text('part_no', null, ['class'=>'form-control','placeholder' => 'Part No Parent', 'onkeydown' => 'keyPressedPart(event)', 'onchange' => 'validatePart()', 'id' => 'part_no']) !!}
                @endif
                <span class="input-group-btn">
                  <button id="btnpopuppart" type="button" class="btn btn-info" data-toggle="modal" data-target="#partModal">
                    <span class="glyphicon glyphicon-search"></span>
                  </button>
                </span>
              </div>
            </div>
            <div class="col-sm-5">
              {!! Form::label('part_name', 'Part Name') !!}
              @if (isset($part_name))
                {!! Form::text('part_name', $part_name, ['class'=>'form-control','placeholder' => 'Part Name', 'disabled'=>'', 'id' => 'part_name']) !!}
              @else 
                {!! Form::text('part_name', null, ['class'=>'form-control','placeholder' => 'Part Name', 'disabled'=>'', 'id' => 'part_name']) !!}
              @endif
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('lblusername2', ' ') !!}
              <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
          </div>
          <!-- /.form-group -->
        </div>
        <!-- /.box-body -->
        
        @if (isset($slst_boms))
          <div class="box-body">
            <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <caption style="display: table-caption;"><strong>Customer: {{ $kd_cust != null ? $kd_cust." - ".$nm_cust : "ALL" }}, Status: {{ $status != null ? $status : "ALL" }}, Part: {{ $part_no != null ? $part_no." - ".$part_name : "ALL" }}</strong></center></caption>
              <thead>
                <tr>
                  <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">No</th>
                  <th colspan="4" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Level Part</th>
                  <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Part Name</th>
                  <th colspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Part Number</th>
                  <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">QPU</th>
                  <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Model</th>
                  <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Status</th>
                  <th colspan="5" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Material Information</th>
                  <th colspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Supplier</th>
                  <th colspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Process</th>
                </tr>
                <tr>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">1</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">2</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">3</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">4</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Customer</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">BAAN</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Spec</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Size</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Weight Consumption</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Weight Finish</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">LOCAL (L) / IMPORT (I) </th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Name</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Code</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Inhouse</th>
                  <th style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;text-align: center">Outhouse</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($slst_boms->get() as $data)
                  <tr>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">{{ $data->no_urut }}</td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">{{ $data->no_lvl1 }}</td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">{{ $data->no_lvl2 }}</td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">{{ $data->no_lvl3 }}</td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">{{ $data->no_lvl4 }}</td>
                    <td style="white-space: nowrap;max-width: 300px;overflow: auto;text-overflow: clip;">
                      {{ $data->part_name }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->part_no_cust }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->part_no_baan }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 3)->format($data->nil_qpu) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->nm_model }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->st_status }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->mat_spec }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->mat_size }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 4)->format($data->mat_weight_consump) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 4)->format($data->mat_weight_finish) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">{{ $data->mat_li }}</td>
                    <td style="white-space: nowrap;max-width: 250px;overflow: auto;text-overflow: clip;">
                      {{ $data->supp_name }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->supp_code }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">
                      {{ $data->proses_in }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: center;">
                      {{ $data->proses_out }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.box-body -->
        @endif
      </div>
      <!-- /.box -->

      <!-- Modal Customer -->
      @include('sales.bom.popup.custModal')
      <!-- Modal Status -->
      @include('sales.bom.popup.statusModal')
      <!-- Modal Part No -->
      @include('sales.bom.popup.partModal')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  document.getElementById("kd_cust").focus();

  //Initialize Select2 Elements
  $(".select2").select2();

  function keyPressedKdCust(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupcust').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('status').focus();
    }
  }

  function keyPressedStatus(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupstatus').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('part_no').focus();
    }
  }

  function keyPressedPart(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopuppart').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('btn-display').focus();
    }
  }

  function popupKdCust() {
    var myHeading = "<p>Popup Customer</p>";
    $("#custModalLabel").html(myHeading);
    var url = '{{ route('datatables.popupCustomerBom') }}';
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
      "order": [[1, 'asc']],
      columns: [
        { data: 'cust_part', name: 'cust_part'},
        { data: 'nama', name: 'nama'}, 
        { data: 'kd_supp', name: 'kd_supp'}, 
        { data: 'kd_cust_igpro', name: 'kd_cust_igpro'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupCust tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupCust.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("kd_cust").value = value["cust_part"];
            document.getElementById("nm_cust").value = value["nama"];
            $('#custModal').modal('hide');
            validateKdCust();
          });
        });
        $('#custModal').on('hidden.bs.modal', function () {
          var kd_cust = document.getElementById("kd_cust").value.trim();
          if(kd_cust === '') {
            document.getElementById("kd_cust").value = "";
            document.getElementById("nm_cust").value = "";
            $('#kd_cust').focus();
          } else {
            $('#status').focus();
          }
        });
      },
    });
  }

  function validateKdCust() {
    var kd_cust = document.getElementById("kd_cust").value.trim();
    if(kd_cust !== '') {
      var url = '{{ route('datatables.validasiCustomerBom', 'param') }}';
      url = url.replace('param', window.btoa(kd_cust));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("kd_cust").value = result["cust_part"];
          document.getElementById("nm_cust").value = result["nama"];
          validateStatus();
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

  function popupStatus() {
    var myHeading = "<p>Popup Status BOM</p>";
    $("#statusModalLabel").html(myHeading);
    var kd_cust = document.getElementById("kd_cust").value.trim();
    if(kd_cust === '') {
      kd_cust = "-";
    }
    var url = '{{ route('datatables.popupStatusBom', 'param') }}';
    url = url.replace('param', window.btoa(kd_cust));
    var lookupStatus = $('#lookupStatus').DataTable({
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
        { data: 'status', name: 'status'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupStatus tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupStatus.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("status").value = value["status"];
            $('#statusModal').modal('hide');
            validateStatus();
          });
        });
        $('#statusModal').on('hidden.bs.modal', function () {
          var status = document.getElementById("status").value.trim();
          if(status === '') {
            document.getElementById("status").value = "";
            $('#status').focus();
          } else {
            $('#part_no').focus();
          }
        });
      },
    });
  }

  function validateStatus() {
    var status = document.getElementById("status").value.trim();
    if(status !== '') {
      var kd_cust = document.getElementById("kd_cust").value.trim();
      if(kd_cust === '') {
        kd_cust = "-";
      }

      var url = '{{ route('datatables.validasiStatusBom', ['param', 'param2']) }}';
      url = url.replace('param2', window.btoa(status));
      url = url.replace('param', window.btoa(kd_cust));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("status").value = result["status"];
        } else {
          document.getElementById("status").value = "";
          document.getElementById("status").focus();
          swal("Status tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("status").value = "";
    }
  }

  function popupPart() {
    var myHeading = "<p>Popup Part No Parent</p>";
    $("#partModalLabel").html(myHeading);
    var kd_cust = document.getElementById("kd_cust").value.trim();
    if(kd_cust === '') {
      kd_cust = "-";
    }
    var status = document.getElementById("status").value.trim();
    if(status === '') {
      status = "-";
    }
    var url = '{{ route('datatables.popupPartBom', ['param', 'param2']) }}';
    url = url.replace('param2', window.btoa(status));
    url = url.replace('param', window.btoa(kd_cust));
    var lookupPart = $('#lookupPart').DataTable({
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
        { data: 'part_no_parent', name: 'part_no_parent'}, 
        { data: 'part_no_cust', name: 'part_no_cust'}, 
        { data: 'part_name', name: 'part_name'}
      ],
      "bDestroy": true,
      "initComplete": function(settings, json) {
        // $('div.dataTables_filter input').focus();
        $('#lookupPart tbody').on( 'dblclick', 'tr', function () {
          var dataArr = [];
          var rows = $(this);
          var rowData = lookupPart.rows(rows).data();
          $.each($(rowData),function(key,value){
            document.getElementById("part_no").value = value["part_no_parent"];
            document.getElementById("part_name").value = value["part_name"];
            $('#partModal').modal('hide');
            validatePart();
          });
        });
        $('#partModal').on('hidden.bs.modal', function () {
          var part_no = document.getElementById("part_no").value.trim();
          if(part_no === '') {
            document.getElementById("part_no").value = "";
            document.getElementById("part_name").value = "";
            $('#part_no').focus();
          } else {
            $('#btn-display').focus();
          }
        });
      },
    });
  }

  function validatePart() {
    var part_no = document.getElementById("part_no").value.trim();
    if(part_no !== '') {
      var kd_cust = document.getElementById("kd_cust").value.trim();
      if(kd_cust === '') {
        kd_cust = "-";
      }
      var status = document.getElementById("status").value.trim();
      if(status === '') {
        status = "-";
      }
      var url = '{{ route('datatables.validasiPartBom', ['param', 'param2', 'param3']) }}';
      url = url.replace('param3', window.btoa(part_no));
      url = url.replace('param2', window.btoa(status));
      url = url.replace('param', window.btoa(kd_cust));
      //use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          document.getElementById("part_no").value = result["part_no_parent"];
          document.getElementById("part_name").value = result["part_name"];
        } else {
          document.getElementById("part_no").value = "";
          document.getElementById("part_name").value = "";
          document.getElementById("part_no").focus();
          swal("Part No tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
    } else {
      document.getElementById("part_no").value = "";
      document.getElementById("part_name").value = "";
    }
  }

  $(document).ready(function(){

    $("#btnpopupcust").click(function(){
      popupKdCust();
    });

    $("#btnpopupstatus").click(function(){
      popupStatus();
    });

    $("#btnpopuppart").click(function(){
      popupPart();
    });

    var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      "ordering": false, 
      // "searching": false,
      "scrollX": true,
      "scrollY": "500px",
      "scrollCollapse": true,
      "paging": false
    });

    $('#btn-display').click( function () {
      var kd_cust = document.getElementById('kd_cust').value.trim();
      if(kd_cust === "") {
        kd_cust = "-";
      }
      var status = document.getElementById('status').value.trim();
      if(status === "") {
        status = "-";
      }
      var part_no = document.getElementById('part_no').value.trim();
      if(part_no === "") {
        part_no = "-";
      }
      var urlRedirect = "{{ route('slstboms.bom', ['param','param2','param3']) }}";
      urlRedirect = urlRedirect.replace('param3', window.btoa(part_no));
      urlRedirect = urlRedirect.replace('param2', window.btoa(status));
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_cust));
      window.location.href = urlRedirect;
    });
  });
</script>
@endsection