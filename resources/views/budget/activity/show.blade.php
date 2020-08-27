@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CR Activities
        <small>Detail CR Activities</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - TRANSAKSI</li>
        <li><a href="{{ route('bgttcrregiss.index') }}"><i class="fa fa-files-o"></i> CR Activities</a></li>
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
              <h3 class="box-title">CR Activities</h3>
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
                      @if ($bgttcrregis->historys()->get()->count() > 0)
                        {{ $bgttcrregis->no_rev }}
                        @foreach ($bgttcrregis->historys()->get() as $history)
                          @if (Auth::user()->can(['budget-cr-activities-*']))
                            {{ "&nbsp;-&nbsp;&nbsp;" }}
                            <a target="_blank" href="{{ route('bgttcrregiss.showrevisi', base64_encode($history->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History No. Revisi {{ $history->no_rev }}">
                              {{ $history->no_rev }}
                            </a>
                          @else
                            {{ "&nbsp;-&nbsp;&nbsp;".$history->no_rev }}
                          @endif
                        @endforeach
                      @else
                        {{ $bgttcrregis->no_rev }}
                      @endif
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
                    <th colspan="2" style="width: 35%;text-align: center">Plan</th>
                    <th colspan="2" style="width: 35%;text-align: center">Actual</th>
                  </tr>
                  <tr>
                    <th style="width: 15%;">Man Power</th>
                    <th style="width: 20%;">Amount</th>
                    <th style="width: 15%;">Man Power</th>
                    <th style="width: 20%;">Amount</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
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
        @if ($bgttcrregis->checkKdDept() === "T" && $bgttcrregis->checkEdit() === "T")
          @if (Auth::user()->can(['budget-cr-activities-create','budget-cr-activities-delete']))
            @if (Auth::user()->can('budget-cr-activities-create'))
              <a class="btn btn-primary" href="{{ route('bgttcrregiss.edit', base64_encode($bgttcrregis->id)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('budget-cr-activities-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('bgttcrregiss.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Daftar CR Activities">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#btn-delete").click(function(){
    var thn = "{{ $bgttcrregis->thn }}";
    var nm_aktivitas = "{{ $bgttcrregis->nm_aktivitas }}";
    var nm_klasifikasi = "{{ $bgttcrregis->nm_klasifikasi }}";
    var nm_kategori = "{{ $bgttcrregis->nm_kategori }}";
    var id_pk = "{{ $bgttcrregis->id }}";
    var msg = "Anda yakin menghapus Activity: " + nm_aktivitas + ", Tahun: " + thn + ", Classification: " + nm_klasifikasi + ", CR Categories: " + nm_kategori + '?';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, delete it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('bgttcrregiss.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(id_pk));
      window.location.href = urlRedirect;
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
  });

  $(document).ready(function(){
    var id = $('#field').data("field-id");
    var url = '{{ route('bgttcrregiss.detail', 'param') }}';
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
        {data: 'amount', name: 'amount', className: "dt-right"},
        {data: 'jml_mp_act', name: 'jml_mp_act', className: "dt-right"},
        {data: 'amount_act', name: 'amount_act', className: "dt-right"}
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

        var column = 4;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 5;
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