@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lalu Lintas
        <small>Detail Kasir ke Accounting</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> FACO - Lalu Lintas</li>
        <li><a href="{{ route('lalins.indexksracc') }}"><i class="fa fa-files-o"></i> Kasir ke Accounting</a></li>
        <li class="active">Detail {{ $data->no_lka }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Kasir ke Accounting</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Serah Terima</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $data->no_lka }}</td>
                    <td style="width: 8%;"><b>Tanggal</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ \Carbon\Carbon::parse($data->tgl_lka)->format('d/m/Y') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Keterangan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $data->ket_lka }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $data->creaby }} - {{ Auth::user()->namaByNpk($data->creaby) }} - {{ \Carbon\Carbon::parse($data->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($data->dtmodi))
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $data->modiby }} - {{ Auth::user()->namaByNpk($data->modiby) }} - {{ \Carbon\Carbon::parse($data->dtmodi)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
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
              <h3 class="box-title">Detail TT / PP</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $data->no_lka }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 12%;">No. TT / PP</th>
                    <th>Supplier</th>
                    <th style="width: 10%;">Tgl JTempo</th>
                    <th style="width: 5%;">MU</th>
                    <th style="width: 10%;">Nilai DPP</th>
                    <th style="width: 10%;">PPn (IDR)</th>
                    <th style="width: 5%;">Batch</th>
                    <th>PIC Serah</th>
                    <th>PIC Tarik</th>
                    <th style="width: 12%;">ACC ke FIN</th>
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

      <div class="box-footer">
        @if (Auth::user()->can('faco-lalin-ksr-acc'))
          <a class="btn btn-success" href="{{ route('lalins.edit', base64_encode($data->no_lka)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">
            <span class="glyphicon glyphicon-edit"></span> Ubah Data
          </a>
          &nbsp;&nbsp;
        @endif
        @if (Auth::user()->can('faco-lalin-ksr-acc-approve'))
          <a class="btn btn-primary" href="{{ route('lalins.terimaksracc', base64_encode($data->no_lka)) }}" data-toggle="tooltip" data-placement="top" title="Terima Data">
            <span class="glyphicon glyphicon-check"></span> Terima Data
          </a>
          &nbsp;&nbsp;
        @endif
        <a class="btn bg-black" href="{{ route('lalins.indexksracc') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Daftar Kasir ke Accounting">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    var no_lka = $('#field').data("field-id");
    var url = '{{ route('lalins.detailksracc', 'param') }}';
    url = url.replace('param', window.btoa(no_lka));
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
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'no_voucher', name: 'no_voucher'},
        {data: 'nm_bpid', name: 'nm_bpid'},
        {data: 'tgl_jtempo', name: 'tgl_jtempo', className: "dt-center"},
        {data: 'ccur', name: 'ccur', className: "dt-center"},
        {data: 'amnt', name: 'amnt', className: "dt-right"},
        {data: 'vath1', name: 'vath1', className: "dt-right"},
        {data: 'no_batch', name: 'no_batch', className: "dt-right"},
        {data: 'creaby', name: 'creaby', className: "none"},
        {data: 'pic_terima', name: 'pic_terima', className: "none", orderable: false, searchable: false},
        {data: 'no_laf', name: 'no_laf'}
      ]
    });
  });
</script>
@endsection