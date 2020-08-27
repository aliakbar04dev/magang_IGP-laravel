@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        FTO DAILY
        <small>FTO Daily</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PPC - Report</li>
        <li class="active"><i class="fa fa-files-o"></i> FTO Daily</li>
      </ol>
    </section>
    <style type="text/css">
      thead, th, td { white-space: nowrap; }
      table.dataTable.no-footer {
        border-bottom: none;
      }
      table.dataTable {
        clear: both;
        margin-top: 6px !important;
        margin-bottom: 0px !important;
        max-width: none !important;
      }
    </style>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">FTO Daily</h3>
        </div>
        <!-- /.box-header -->
        
        <div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('lblsite', 'Site') !!}
              <select id="filter_site" name="filter_site" aria-controls="filter_customer" class="form-control select2">
                <option value="ALL" @if ("ALL" == $kd_site) selected="selected" @endif>ALL</option>
                <option value="IGPJ" @if ("IGPJ" == $kd_site) selected="selected" @endif>IGP - JAKARTA</option>
                <option value="IGPK" @if ("IGPK" == $kd_site) selected="selected" @endif>IGP - KARAWANG</option>
              </select>
            </div>
            <div class="col-sm-3">
              {!! Form::label('filter_tahun', 'Tahun') !!}
              <select id="filter_tahun" name="filter_tahun" aria-controls="filter_customer" 
              class="form-control select2">
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                  @if ($i == $kd_tahun)
                    <option value={{ $i }} selected="selected">{{ $i }}</option>
                  @else
                    <option value={{ $i }}>{{ $i }}</option>
                  @endif
                @endfor
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Bulan') !!}
              <select id="filter_bulan" name="filter_bulan" aria-controls="filter_customer" 
              class="form-control select2">
                <option value="01" @if ("01" == $kd_bulan) selected="selected" @endif>Januari</option>
                <option value="02" @if ("02" == $kd_bulan) selected="selected" @endif>Februari</option>
                <option value="03" @if ("03" == $kd_bulan) selected="selected" @endif>Maret</option>
                <option value="04" @if ("04" == $kd_bulan) selected="selected" @endif>April</option>
                <option value="05" @if ("05" == $kd_bulan) selected="selected" @endif>Mei</option>
                <option value="06" @if ("06" == $kd_bulan) selected="selected" @endif>Juni</option>
                <option value="07" @if ("07" == $kd_bulan) selected="selected" @endif>Juli</option>
                <option value="08" @if ("08" == $kd_bulan) selected="selected" @endif>Agustus</option>
                <option value="09" @if ("09" == $kd_bulan) selected="selected" @endif>September</option>
                <option value="10" @if ("10" == $kd_bulan) selected="selected" @endif>Oktober</option>
                <option value="11" @if ("11" == $kd_bulan) selected="selected" @endif>November</option>
                <option value="12" @if ("12" == $kd_bulan) selected="selected" @endif>Desember</option>
              </select>
            </div>
          </div>
          <!-- /.form-group -->
          <div class="form-group">
            <div class="col-sm-3">
              {!! Form::label('lblPlant', 'Plant') !!}
              <select id="filter_plant" name="filter_plant" aria-controls="filter_customer" class="form-control select2">
                @foreach ($plants->get() as $plants)
                  <option value={{ $plants->kd_plant }} @if ($plants->kd_plant == $kd_plant) selected="selected" @endif >{{ $plants->nm_plant }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-3">
              {!! Form::label('lblCustomer', 'Customer') !!}
              <select id="filter_customer" name="filter_customer" aria-controls="filter_customer" class="form-control select2">
                @foreach ($customers->get() as $customers)
                  <option value={{ $customers->kd_sold_to }} @if ($customers->kd_sold_to == $kd_customer) selected="selected" @endif>{{ $customers->nama.' - '. $customers->kd_sold_to }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lbldisplay', 'Action') !!}
              <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
            </div>
          </div>          
        </div>
        <!-- /.box-body -->

        <div class="box-body">
          <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr align="center">
                <th>No</th>
                <th>KODE DOCK</th>
                <th>PART NO</th>
                <th>PART NAME</th>
                <th>JENIS PART</th>
                <th>N0</th>
                <th>N1</th>
                <th>N2</th>
                <th>N3</th>
                <th>TGL1</th>
                <th>TGL2</th>
                <th>TGL3</th>
                <th>TGL4</th>
                <th>TGL5</th>
                <th>TGL6</th>
                <th>TGL7</th>
                <th>TGL8</th>
                <th>TGL9</th>
                <th>TGL10</th>
                <th>TGL11</th>
                <th>TGL12</th>
                <th>TGL13</th>
                <th>TGL14</th>
                <th>TGL15</th>
                <th>TGL16</th>
                <th>TGL17</th>
                <th>TGL18</th>
                <th>TGL19</th>
                <th>TGL20</th>
                <th>TGL21</th>
                <th>TGL22</th>
                <th>TGL23</th>
                <th>TGL24</th>
                <th>TGL25</th>
                <th>TGL26</th>
                <th>TGL27</th>
                <th>TGL28</th>
                <th>TGL29</th>
                <th>TGL30</th>
                <th>TGL31</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($listfto->get() as $data)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $data->kd_dock }}</td>
                  <td>{{ $data->part_no }}</td>
                  <td>{{ $data->nm_part }}</td>
                  <td>{{ $data->jenis_part }}</td>
                  <td>{{ $data->n0 }}</td>
                  <td>{{ $data->n1 }}</td>
                  <td>{{ $data->n2 }}</td>
                  <td>{{ $data->n3 }}</td>
                  <td>{{ $data->tgl1 }}</td>
                  <td>{{ $data->tgl2 }}</td>
                  <td>{{ $data->tgl3 }}</td>
                  <td>{{ $data->tgl4 }}</td>
                  <td>{{ $data->tgl5 }}</td>
                  <td>{{ $data->tgl6 }}</td>
                  <td>{{ $data->tgl7 }}</td>
                  <td>{{ $data->tgl8 }}</td>
                  <td>{{ $data->tgl9 }}</td>
                  <td>{{ $data->tgl10 }}</td>
                  <td>{{ $data->tgl11 }}</td>
                  <td>{{ $data->tgl12 }}</td>
                  <td>{{ $data->tgl13 }}</td>
                  <td>{{ $data->tgl14 }}</td>
                  <td>{{ $data->tgl15 }}</td>
                  <td>{{ $data->tgl16 }}</td>
                  <td>{{ $data->tgl17 }}</td>
                  <td>{{ $data->tgl18 }}</td>
                  <td>{{ $data->tgl19 }}</td>
                  <td>{{ $data->tgl20 }}</td>
                  <td>{{ $data->tgl21 }}</td>
                  <td>{{ $data->tgl22 }}</td>
                  <td>{{ $data->tgl23 }}</td>
                  <td>{{ $data->tgl24 }}</td>
                  <td>{{ $data->tgl25 }}</td>
                  <td>{{ $data->tgl26 }}</td>
                  <td>{{ $data->tgl27 }}</td>
                  <td>{{ $data->tgl28 }}</td>
                  <td>{{ $data->tgl29 }}</td>
                  <td>{{ $data->tgl30 }}</td>
                  <td>{{ $data->tgl31 }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-body">
          <table id="tblMasterAvg" class="table table-bordered table-striped" cellspacing="0" width="100%">
            <thead>
              <tr align="center" style="background-color: white">
                <th>No</th>
                <th>JENIS</th>
                <th>N0</th>
                <th>N1</th>
                <th>N2</th>
                <th>N3</th>
                <th>TGL1</th>
                <th>TGL2</th>
                <th>TGL3</th>
                <th>TGL4</th>
                <th>TGL5</th>
                <th>TGL6</th>
                <th>TGL7</th>
                <th>TGL8</th>
                <th>TGL9</th>
                <th>TGL10</th>
                <th>TGL11</th>
                <th>TGL12</th>
                <th>TGL13</th>
                <th>TGL14</th>
                <th>TGL15</th>
                <th>TGL16</th>
                <th>TGL17</th>
                <th>TGL18</th>
                <th>TGL19</th>
                <th>TGL20</th>
                <th>TGL21</th>
                <th>TGL22</th>
                <th>TGL23</th>
                <th>TGL24</th>
                <th>TGL25</th>
                <th>TGL26</th>
                <th>TGL27</th>
                <th>TGL28</th>
                <th>TGL29</th>
                <th>TGL30</th>
                <th>TGL31</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($listftoavg->get() as $data)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $data->jenis_part }}</td>
                  <td>{{ $data->n0 }}</td>
                  <td>{{ $data->n1 }}</td>
                  <td>{{ $data->n2 }}</td>
                  <td>{{ $data->n3 }}</td>
                  <td>{{ $data->tgl1 }}</td>
                  <td>{{ $data->tgl2 }}</td>
                  <td>{{ $data->tgl3 }}</td>
                  <td>{{ $data->tgl4 }}</td>
                  <td>{{ $data->tgl5 }}</td>
                  <td>{{ $data->tgl6 }}</td>
                  <td>{{ $data->tgl7 }}</td>
                  <td>{{ $data->tgl8 }}</td>
                  <td>{{ $data->tgl9 }}</td>
                  <td>{{ $data->tgl10 }}</td>
                  <td>{{ $data->tgl11 }}</td>
                  <td>{{ $data->tgl12 }}</td>
                  <td>{{ $data->tgl13 }}</td>
                  <td>{{ $data->tgl14 }}</td>
                  <td>{{ $data->tgl15 }}</td>
                  <td>{{ $data->tgl16 }}</td>
                  <td>{{ $data->tgl17 }}</td>
                  <td>{{ $data->tgl18 }}</td>
                  <td>{{ $data->tgl19 }}</td>
                  <td>{{ $data->tgl20 }}</td>
                  <td>{{ $data->tgl21 }}</td>
                  <td>{{ $data->tgl22 }}</td>
                  <td>{{ $data->tgl23 }}</td>
                  <td>{{ $data->tgl24 }}</td>
                  <td>{{ $data->tgl25 }}</td>
                  <td>{{ $data->tgl26 }}</td>
                  <td>{{ $data->tgl27 }}</td>
                  <td>{{ $data->tgl28 }}</td>
                  <td>{{ $data->tgl29 }}</td>
                  <td>{{ $data->tgl30 }}</td>
                  <td>{{ $data->tgl31 }}</td>
                </tr>
              @endforeach
            </tbody>
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

  $(document).ready(function(){

     var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      // 'responsive': true,
      "scrollX": true,
      "scrollY": "400px",
      "scrollCollapse": true,
      fixedColumns:   {
            leftColumns: 5,
            rightColumns: 0
        }
    });

     var tableAvg = $('#tblMasterAvg').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      // 'responsive': true,
      "scrollX": true,
      "scrollY": "400px",
      "scrollCollapse": true
    });


    $('#display').click( function () {
      var site = document.getElementById('filter_site').value.trim();
      var tahun = document.getElementById('filter_tahun').value.trim();
      var bulan = document.getElementById('filter_bulan').value.trim();
      var kd_plant = document.getElementById('filter_plant').value.trim();
      var customer = document.getElementById('filter_customer').value.trim();

      var urlRedirect = "{{ route('ppcvftodays.index', ['param','param2','param3','param4','param5']) }}";
      urlRedirect = urlRedirect.replace('param5', window.btoa(customer));
      urlRedirect = urlRedirect.replace('param4', window.btoa(kd_plant));
      urlRedirect = urlRedirect.replace('param3', window.btoa(bulan));
      urlRedirect = urlRedirect.replace('param2', window.btoa(tahun));
      urlRedirect = urlRedirect.replace('param', window.btoa(site));
      window.location.href = urlRedirect;
    });

    document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.top = "-7px";
    document.getElementsByClassName('DTFC_LeftBodyLiner')[0].style.overflowY = "scroll";
  });
</script>
@endsection