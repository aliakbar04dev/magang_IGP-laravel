@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        History CR Activities
        <small>Detail History CR Activities</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - TRANSAKSI</li>
        <li><i class="fa fa-files-o"></i> History CR Activities</li>
        <li class="active">Detail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">History CR Activities</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>Tahun</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $bgttcrregis->thn }}</td>
                    <td style="width: 12%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ $bgttcrregis->no_rev }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Activity</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $bgttcrregis->nm_aktivitas }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Classification</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $bgttcrregis->nm_klasifikasi }}</td>
                    <td style="width: 12%;"><b>CR Categories</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrregis->nm_kategori }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Divisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $bgttcrregis->kd_div }} - {{ $bgttcrregis->namaDivisi($bgttcrregis->kd_div) }}</td>
                    <td style="width: 12%;"><b>Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrregis->kd_dep }} - {{ $bgttcrregis->namaDepartemen($bgttcrregis->kd_dep) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->creaby }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->creaby) }} - {{ \Carbon\Carbon::parse($bgttcrregis->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($bgttcrregis->dtmodi))
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->modiby }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->modiby) }} - {{ \Carbon\Carbon::parse($bgttcrregis->dtmodi)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrregis->submit_dt))
                  <tr>
                    <td style="width: 12%;"><b>Submit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->submit_by }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->submit_by) }} - {{ \Carbon\Carbon::parse($bgttcrregis->submit_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrregis->apr_dep_dt))
                  <tr>
                    <td style="width: 12%;"><b>Approve Dept.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->apr_dep_by }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->apr_dep_by) }} - {{ \Carbon\Carbon::parse($bgttcrregis->apr_dep_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrregis->rjt_dep_dt))
                  <tr>
                    <td style="width: 12%;"><b>Reject Dept.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->rjt_dep_by }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->rjt_dep_by) }} - {{ \Carbon\Carbon::parse($bgttcrregis->rjt_dep_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Ket. Reject</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->rjt_dep_ket }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrregis->apr_div_dt))
                  <tr>
                    <td style="width: 12%;"><b>Approve Div.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->apr_div_by }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->apr_div_by) }} - {{ \Carbon\Carbon::parse($bgttcrregis->apr_div_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrregis->rjt_div_dt))
                  <tr>
                    <td style="width: 12%;"><b>Reject Div.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->rjt_div_by }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->rjt_div_by) }} - {{ \Carbon\Carbon::parse($bgttcrregis->rjt_div_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Ket. Reject</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->rjt_div_ket }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrregis->apr_bgt_dt))
                  <tr>
                    <td style="width: 12%;"><b>Approve Budget</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->apr_bgt_by }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->apr_bgt_by) }} - {{ \Carbon\Carbon::parse($bgttcrregis->apr_bgt_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrregis->rjt_bgt_dt))
                  <tr>
                    <td style="width: 12%;"><b>Reject Budget</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->rjt_bgt_by }} - {{ $bgttcrregis->namaByNpk($bgttcrregis->rjt_bgt_by) }} - {{ \Carbon\Carbon::parse($bgttcrregis->rjt_bgt_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Ket. Reject</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->rjt_bgt_ket }}
                    </td>
                  </tr>
                  @endif
                  <tr>
                    <td style="width: 12%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrregis->status }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $bgttcrregis->id }}">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" style="width: 5%;">No</th>
                    <th rowspan="2">Bulan</th>
                    <th colspan="2" style="width: 40%;text-align: center">Plan</th>
                  </tr>
                  <tr>
                    <th style="width: 20%;">Man Power</th>
                    <th style="width: 20%;">Amount</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="box-footer">
        <a class="btn btn-primary" href="#" onclick="window.open('', '_self', ''); window.close();" data-toggle="tooltip" data-placement="top" title="Close Tab">Close</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    var id = $('#field').data("field-id");
    var url = '{{ route('bgttcrregiss.detailrevisi', 'param') }}';
    url = url.replace('param', window.btoa(id));
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
      "order": [],
      processing: true, 
      // serverSide: true,
      searching: false, 
      paging: false, 
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'bulan', name: 'bulan'},
        {data: 'jml_mp', name: 'jml_mp', className: "dt-right"},
        {data: 'amount', name: 'amount', className: "dt-right"}
      ], 
      "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
          return typeof i === 'string' ?
          i.replace(/[\$,]/g, '')*1 :
          typeof i === 'number' ?
          i : 0;
        };

        var column = 2;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 3;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );
      }
    });
  });
</script>
@endsection