@extends('monitoring.ehs.layouts.app')

@section('content')
  <BR>
  <div class="container2">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <center><a href="{{ url('/monitoringwp') }}"><h4>Monitoring Level Instalasi Air Limbah
</h4></a></center>
          </div>

          <div class="panel-body">
              <label><strong>Tanggal : </strong></label>
              @if (empty($tgl))
                {!! Form::date('filter_tgl', \Carbon\Carbon::now(), ['placeholder' => 'Tanggal', 'id' => 'filter_tgl', 'onchange' => 'changeTgl()']) !!}
              @else
                {!! Form::date('filter_tgl', \Carbon\Carbon::createFromFormat('Ymd', base64_decode($tgl)), ['placeholder' => 'Tanggal', 'id' => 'filter_tgl', 'onchange' => 'changeTgl()']) !!}
              @endif
            </div>

             <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:0px;">
            <img src="{{ asset('images/red.png') }}" alt="X"> High Risk
            <img src="{{ asset('images/yellow.png') }}" alt="X"> Medium Risk
            <img src="{{ asset('images/green.png') }}" alt="X"> Low Risk
          </div>
            <!-- /.box-body -->

          <div class="panel-body">
            <table id="tblMaster" class="table table-bordered" cellspacing="0" width="100%">
                  <thead>
                        <tr>
                          <th style='width: 1%;text-align: center'>No</th>
                          <th style='width: 15%;text-align: center'>Tanggal</th>
                          <th  style='text-align: center'>Nama Proses</th>
                          <th style='width: 10%;text-align: center'>Level (m)</th>
                          <th style='width: 15%;text-align: center'>Volume (m3)</th>
                          <th style='width: 10%;text-align: center'>Status</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
<script>
  
  function changeTgl() {
    var var_tgl = document.getElementById("filter_tgl").value.trim();
    if(var_tgl !== "") {
      var date = new Date(var_tgl);
      var tahun = date.getFullYear();
          var bulan = date.getMonth() + 1;
          if(bulan < 10) {
            bulan = "0" + bulan;
          }
          var tgl = date.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }
          var param = tahun + "" + bulan + "" + tgl;
          var urlRedirect = "{{ url('/monitoringwp/param') }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(param));
        window.location.href = urlRedirect;
    }
  }

  $(document).ready(function(){
    var tableMaster = $('#tblMaster').DataTable({
      // "columnDefs": [{
      //  "searchable": false,
      //  "orderable": false,
      //  "targets": 0,
      //  render: function (data, type, row, meta) {
      //    return meta.row + meta.settings._iDisplayStart + 1;
      //  }
      // }],
        "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
        "iDisplayLength": 10,
        "displayStart": {{ $displayStart }},
        "responsive": true,
        "scrollX": false,
        "order": [[7, 'asc']],
        columns: [
          // {data: null, name: null},
          {orderable: false, searchable: false},
          {orderable: true, searchable: true},
          {orderable: true, searchable: true},
          {orderable: false, searchable: false},
          {orderable: true, searchable: true},
          {orderable: true, searchable: true},
          {orderable: true, searchable: true},
        ],
      });

      $(function() {
        $('\
          <div id="filter_status" class="dataTables_length" style="display: inline-block; margin-left:0px;">\
            <img src="{{ asset('images/red.png') }}" alt="X"> High Risk \
            <img src="{{ asset('images/yellow.png') }}" alt="X"> Medium Risk \
            <img src="{{ asset('images/green.png') }}" alt="X"> Low Risk \
          </div>\
        ').insertAfter('.dataTables_length');
      });
  });

    //auto refresh
  setTimeout(function() {
      var var_tgl = document.getElementById("filter_tgl").value.trim();
    if(var_tgl !== "") {
      var date = new Date(var_tgl);
      var tahun = date.getFullYear();
          var bulan = date.getMonth() + 1;
          if(bulan < 10) {
            bulan = "0" + bulan;
          }
          var tgl = date.getDate();
          if(tgl < 10) {
            tgl = "0" + tgl;
          }

          var param = tahun + "" + bulan + "" + tgl;
          var displayStart = "{{ $displayStart }}";
        displayStart = Number(displayStart) + 10;


          var urlRedirect = "{{ url('/monitoringwp/param/param2') }}";
          urlRedirect = urlRedirect.replace('param2', displayStart);
        urlRedirect = urlRedirect.replace('param', window.btoa(param));
        window.location.href = urlRedirect;
    }
  }, 180000); //1000 = 1 second
</script>
@endsection