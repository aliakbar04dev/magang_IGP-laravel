@extends('monitoring.mtc.layouts.app3')

@section('content')
  <div class="container3">
    <div class="row" id="box-body" name="box-body">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <center><h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;"><strong>DAFTAR MASALAH IGP-{{ $kd_plant }} ZONA {{ $lok_zona }}</strong></h3></center>
            <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          
          <div class="box-body" id="box-table" name="box-table">
            <input type="hidden" id="filter_status" name="filter_status" class="form-control" readonly="readonly" value="OPEN">
            <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
              <thead>
                <tr>
                  <th style="width: 1%;">No</th>
                  <th style="width: 5%;">Tgl</th>
                  <th style="width: 20%;">Mesin</th>
                  <th style="width: 10%;">Line</th>
                  <th style="width: 19%;">Problem</th>
                  <th>Counter Measure</th>
                  <th style="width: 10%;">No. DM</th>
                  <th style="width: 10%;">No. LP</th>
                  <th>Site</th>
                  <th>Plant</th>
                  <th>No. PI</th>
                  <th>Creaby</th>
                  <th>Modiby</th>
                  <th>Submit</th>
                  <th>Approve PIC</th>
                  <th>Approve Foreman</th>
                  <th>Reject</th>
                  <th>Tgl Plan Pengerjaan</th>
                  <th>Status CMS</th>
                  <th>Tgl Plan CMS</th>
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
  <footer style="background-color:white; min-height:50px;" class="navbar-fixed-bottom">
      <center>
        <a href="{{ route('smartmtcs.dashboardmtc2') }}" class="btn bg-navy">Home</a>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{ route('smartmtcs.problist') }}" class="btn bg-navy">Back</a>
  </center>
    </footer>
@endsection

@section('scripts')
<script type="text/javascript">
var urlParams = new URLSearchParams(window.location.search);
// let smartmtc = urlParams.has('type'); 
console.log(urlParams.has('type'))
if(urlParams.has('type')){
  var x = document.getElementById("btn-close");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

  var calcDataTableHeight = function() {
    return $(window).height() * 75 / 100;
  };

  $(document).ready(function(){
    var url = '{{ route('smartmtcs.dashboarddm', ['param','param2']) }}';
    url = url.replace('param2', window.btoa("{{ $lok_zona }}"));
    url = url.replace('param', window.btoa("{{ $kd_plant }}"));
    var tableMaster = $('#tblMaster').DataTable({
      "columnDefs": [{
        "searchable": false,
        // "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": -1,
      responsive: true,
      "scrollY": calcDataTableHeight(),
      "scrollCollapse": true,
      // "order": [[1, 'desc'],[2, 'asc'],[3, 'asc']],
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      // "dom": '<"top"fli>rt<"bottom"p><"clear">', 
      "dom": '<"top"fli>rt<"clear">', 
      // serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'tgl_dm', name: 'tgl_dm'},
        {data: 'mesin', name: 'mesin'},
        {data: 'line', name: 'line'}, 
        {data: 'ket_prob', name: 'ket_prob'},
        {data: 'ket_cm', name: 'ket_cm'},
        {data: 'no_dm', name: 'no_dm', className: "dt-center"}, 
        {data: 'no_lp', name: 'no_lp', className: "dt-center", orderable: false, searchable: false},
        {data: 'kd_site', name: 'kd_site', className: "none"},
        {data: 'kd_plant', name: 'kd_plant', className: "none"},
        {data: 'no_pi', name: 'no_pi', className: "none"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'modiby', name: 'modiby', className: "none"},
        {data: 'submit_npk', name: 'submit_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_pic_npk', name: 'apr_pic_npk', className: "none", orderable: false, searchable: false},
        {data: 'apr_fm_npk', name: 'apr_fm_npk', className: "none", orderable: false, searchable: false},
        {data: 'rjt_npk', name: 'rjt_npk', className: "none", orderable: false, searchable: false},
        {data: 'tgl_plan_mulai', name: 'tgl_plan_mulai', className: "none", orderable: false, searchable: false},
        {data: 'st_cms', name: 'st_cms', className: "none", orderable: false, searchable: false},
        {data: 'tgl_plan_cms', name: 'tgl_plan_cms', className: "none", orderable: false, searchable: false}
      ]
    });

    $(function() {
      $('\
        <center>\
        <div style="display: inline-block; margin-left:10px;">\
          <button class="btn btn-primary" id="btn-st-all" name="btn-st-all">ALL</button>&nbsp;&nbsp;\
          <button class="btn btn-success" id="btn-st-open" name="btn-st-open">OPEN</button>&nbsp;&nbsp;\
          <button class="btn btn-primary" id="btn-st-close" name="btn-st-close">CLOSE</button>\
        </div>\
        </center>\
      ').insertAfter('.dataTables_length');

      $("#tblMaster").on('preXhr.dt', function(e, settings, data) {
        data.status_apr = document.getElementById("filter_status").value;
      });

      $('#btn-st-all').click( function () {
        document.getElementById("filter_status").value = "ALL";
        $('#btn-st-all').removeAttr('class');
        $('#btn-st-all').attr('class', 'btn btn-success');
        $('#btn-st-open').removeAttr('class');
        $('#btn-st-open').attr('class', 'btn btn-primary');
        $('#btn-st-close').removeAttr('class');
        $('#btn-st-close').attr('class', 'btn btn-primary');
        tableMaster.ajax.reload();
      });

      $('#btn-st-open').click( function () {
        document.getElementById("filter_status").value = "OPEN";
        $('#btn-st-all').removeAttr('class');
        $('#btn-st-all').attr('class', 'btn btn-primary');
        $('#btn-st-open').removeAttr('class');
        $('#btn-st-open').attr('class', 'btn btn-success');
        $('#btn-st-close').removeAttr('class');
        $('#btn-st-close').attr('class', 'btn btn-primary');
        tableMaster.ajax.reload();
      });

      $('#btn-st-close').click( function () {
        document.getElementById("filter_status").value = "LP";
        $('#btn-st-all').removeAttr('class');
        $('#btn-st-all').attr('class', 'btn btn-primary');
        $('#btn-st-open').removeAttr('class');
        $('#btn-st-open').attr('class', 'btn btn-primary');
        $('#btn-st-close').removeAttr('class');
        $('#btn-st-close').attr('class', 'btn btn-success');
        tableMaster.ajax.reload();
      });
    });
  });
</script>
@endsection