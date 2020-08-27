@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Masalah [Plant]
        <small>Detail Daftar Masalah</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('mtctdftmslhplants.index') }}"><i class="fa fa-files-o"></i> Daftar Masalah [Plant]</a></li>
        <li class="active">Detail {{ $mtctdftmslh->no_dm }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Masalah [Plant]</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. DM</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mtctdftmslh->no_dm }}</td>
                    <td style="width: 10%;"><b>Tgl DM</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mtctdftmslh->kd_site }}</td>
                    <td style="width: 10%;"><b>Plant</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctdftmslh->kd_plant }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Line</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->kd_line }} - {{ $mtctdftmslh->nm_line }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Mesin</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->kd_mesin }} - {{ $mtctdftmslh->nm_mesin }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Problem</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_prob }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Counter Measure</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_cm }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Spare Part</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_sp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Evaluasi Hasil</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_eva_hasil }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Remain</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_remain }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Remark</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_remark }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->lok_pict))
                        <p>
                          <img src="{{ $mtctdftmslh->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. PI</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $mtctdftmslh->no_pi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. LP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->tmtcwo1()))
                        @if (Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp']))
                          <a href="{{ route('tmtcwo1s.show', base64_encode($mtctdftmslh->tmtcwo1()->no_wo)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail LP {{ $mtctdftmslh->tmtcwo1()->no_wo }}">{{ $mtctdftmslh->tmtcwo1()->no_wo }}</a>
                        @else
                          {{ $mtctdftmslh->tmtcwo1()->no_wo }}
                        @endif
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->kd_dep))
                        {{ $mtctdftmslh->kd_dep }} - {{ $mtctdftmslh->desc_dep }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->dtcrea))
                        {{ $mtctdftmslh->creaby }} - {{ $mtctdftmslh->nama($mtctdftmslh->creaby) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $mtctdftmslh->creaby }} - {{ $mtctdftmslh->nama($mtctdftmslh->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->dtmodi))
                        {{ $mtctdftmslh->modiby }} - {{ $mtctdftmslh->nama($mtctdftmslh->modiby) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $mtctdftmslh->modiby }} - {{ $mtctdftmslh->nama($mtctdftmslh->modiby) }}
                      @endif
                    </td>
                  </tr>
                  @if (!empty($mtctdftmslh->submit_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Submit DM</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->submit_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->submit_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->submit_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($mtctdftmslh->apr_pic_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Approve PIC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->apr_pic_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->apr_pic_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->apr_pic_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($mtctdftmslh->apr_fm_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Approve Foreman</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->apr_fm_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->apr_fm_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->apr_fm_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($mtctdftmslh->rjt_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->rjt_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->rjt_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->rjt_tgl)->format('d/m/Y H:i') }} - {{ $mtctdftmslh->rjt_st }} - {{ $mtctdftmslh->rjt_ket }}
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 13%;"><b>Tgl Plan Pengerjaan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->tgl_plan_mulai))
                        {{ \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_selesai)->format('d/m/Y H:i') }}
                      @endif
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
      <div class="box-footer">
        @if ($mtctdftmslh->submit_tgl == null && $mtctdftmslh->ket_cm == null)
          @if (Auth::user()->can(['mtc-dmplant-create','mtc-dmplant-delete']) && $mtctdftmslh->checkEdit() === "T")
            @if (Auth::user()->can('mtc-dmplant-create'))
              <a class="btn btn-primary" href="{{ route('mtctdftmslhplants.edit', base64_encode($mtctdftmslh->no_dm)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('mtc-dmplant-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('mtctdftmslhplants.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard DM [Plant]">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#btn-delete").click(function(){
    var no_dm = "{{ $mtctdftmslh->no_dm }}";
    var msg = 'Anda yakin menghapus No. DM ' + no_dm;
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
      var urlRedirect = "{{ route('mtctdftmslhplants.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_dm));
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
</script>
@endsection