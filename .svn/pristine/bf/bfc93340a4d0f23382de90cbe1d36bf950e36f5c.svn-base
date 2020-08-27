@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Surat Jalan Claim
        <small>Detail Surat Jalan Claim</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> CLAIM - TRANSAKSI</li>
        <li><a href="{{ route('ppctdnclaimsj1s.index') }}"><i class="fa fa-files-o"></i> SURAT JALAN CLAIM</a></li>
        <li class="active">Detail {{ $ppctdnclaimsj1->no_sj }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Surat Jalan Claim</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Surat Jalan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $ppctdnclaimsj1->no_sj }}</td>
                    <td style="width: 12%;"><b>Tgl Surat Jalan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($ppctdnclaimsj1->tgl_sj)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. DN</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $ppctdnclaimsj1->no_dn }}</td>
                    <td style="width: 12%;"><b>Supplier</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ppctdnclaimsj1->kd_bpid }} - {{ $ppctdnclaimsj1->namaSupp($ppctdnclaimsj1->kd_bpid) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($ppctdnclaimsj1->dtcrea))
                        {{ $ppctdnclaimsj1->creaby }} - {{ $ppctdnclaimsj1->nama($ppctdnclaimsj1->creaby) }} - {{ \Carbon\Carbon::parse($ppctdnclaimsj1->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $ppctdnclaimsj1->creaby }} - {{ $ppctdnclaimsj1->nama($ppctdnclaimsj1->creaby) }}
                      @endif
                    </td>
                  </tr>
                  @if (!empty($ppctdnclaimsj1->tgl_submit))
                    <tr>
                      <td style="width: 12%;"><b>Submit</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdnclaimsj1->pic_submit }} - {{ $ppctdnclaimsj1->nama($ppctdnclaimsj1->pic_submit) }} - {{ \Carbon\Carbon::parse($ppctdnclaimsj1->tgl_submit)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdnclaimsj1->tgl_aprov))
                    <tr>
                      <td style="width: 12%;"><b>Approve</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdnclaimsj1->pic_aprov }} - {{ $ppctdnclaimsj1->nama($ppctdnclaimsj1->pic_aprov) }} - {{ \Carbon\Carbon::parse($ppctdnclaimsj1->tgl_aprov)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdnclaimsj1->tgl_reject))
                    <tr>
                      <td style="width: 12%;"><b>Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4" style="white-space:pre;">
                        {{ $ppctdnclaimsj1->pic_reject }} - {{ $ppctdnclaimsj1->nama($ppctdnclaimsj1->pic_reject) }} - {{ \Carbon\Carbon::parse($ppctdnclaimsj1->tgl_reject)->format('d/m/Y H:i') }} - {{ $ppctdnclaimsj1->ket_reject }}
                      </td>
                    </tr>
                  @endif
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->

            <div class="box-body">
              <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" style="width: 5%;">No. POS</th>
                    <th rowspan="2" style="width: 15%;">Item</th>
                    <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Deskripsi</th>
                    <th rowspan="2" style="white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">Keterangan</th>
                    <th colspan="3" style="text-align:center;">QTY</th>
                  </tr>
                  <tr>
                    <th style="width: 10%;">DN</th>
                    <th style="width: 11%;">Kirim IGP</th>
                    <th style="width: 10%;">SJ</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($ppctdnclaimsj1->ppctDnclaimSj2s()->get() as $data)
                  <tr>
                    <td style="text-align: center;">
                      {{ $data->no_pos }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">
                      {{ $data->kd_item }}
                    </td>
                    <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                      {{ $data->item_name }}
                    </td>
                    <td style="white-space: nowrap;max-width: 200px;overflow: auto;text-overflow: clip;">
                      {{ $data->nm_trket }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 2)->format($data->qty_dn) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 2)->format($data->qty_kirim) }}
                    </td>
                    <td style="white-space: nowrap;overflow: auto;text-overflow: clip;text-align: right;">
                      {{ numberFormatter(0, 2)->format($data->qty_sj) }}
                    </td>
                  </tr>
                  @endforeach
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
      <div class="box-footer">
        @if ($ppctdnclaimsj1->tgl_submit == null)
          @if (Auth::user()->can(['ppc-dnclaim-create','ppc-dnclaim-delete']) && $ppctdnclaimsj1->checkEdit() === "T")
            @if (Auth::user()->can('ppc-dnclaim-create'))
              <a class="btn btn-primary" href="{{ route('ppctdnclaimsj1s.edit', base64_encode($ppctdnclaimsj1->no_certi)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('ppc-dnclaim-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
          @endif
        @elseif ($ppctdnclaimsj1->tgl_aprov == null)
          @if (Auth::user()->can(['ppc-dnclaim-create']))
            <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Surat Jalan Claim {{ $ppctdnclaimsj1->no_sj }}" href="{{ route('ppctdnclaimsj1s.print', base64_encode($ppctdnclaimsj1->no_certi)) }}">Print Surat Jalan Claim</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can(['ppc-dnclaim-create']))
            <a class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Unsubmit Surat Jalan Claim {{ $ppctdnclaimsj1->no_certi }}" href="{{ route('ppctdnclaimsj1s.unsubmit', base64_encode($ppctdnclaimsj1->no_certi)) }}">Unsubmit Surat Jalan Claim</a>
            &nbsp;&nbsp;
          @endif
        @else 
          @if (Auth::user()->can(['ppc-dnclaim-create']))
            <a target="_blank" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Surat Jalan Claim {{ $ppctdnclaimsj1->no_certi }}" href="{{ route('ppctdnclaimsj1s.print', base64_encode($ppctdnclaimsj1->no_certi)) }}">Print Surat Jalan Claim</a>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('ppctdnclaimsj1s.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Surat Jalan Claim">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#btn-delete").click(function(){
    var no_certi = "{{ $ppctdnclaimsj1->no_certi }}";
    var no_sj = "{{ $ppctdnclaimsj1->no_sj }}";
    var msg = 'Anda yakin menghapus Surat Jalan Claim: ' + no_sj;
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
      var urlRedirect = "{{ route('ppctdnclaimsj1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_certi));
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
    var table = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      "responsive": true,
      // "ordering": false, 
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "500px",
      // "scrollCollapse": true
    });
  });
</script>
@endsection