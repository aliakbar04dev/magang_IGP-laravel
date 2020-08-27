@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Genba DEP
        <small>Detail Genba DEP</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MANAGEMENT - Transaksi</li>
        <li><a href="{{ route('mgmtgembadeps.index') }}"><i class="fa fa-files-o"></i> Daftar Genba DEP</a></li>
        <li class="active">Detail {{ $mgmtgembadep->no_gemba }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Genba DEP</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mgmtgembadep->no_gemba }}</td>
                    <td style="width: 10%;"><b>Tgl Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mgmtgembadep->tgl_gemba)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">
                      @if ($mgmtgembadep->kd_site === "IGPJ")
                        IGP - JAKARTA
                      @elseif ($mgmtgembadep->kd_site === "IGPK")
                        IGP - KARAWANG
                      @else 
                        {{ $mgmtgembadep->kd_site }}
                      @endif
                    </td>
                    <td style="width: 10%;"><b>PIC Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mgmtgembadep->npk_pic }} - {{ $mgmtgembadep->nm_pic }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Sub PIC Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if ($mgmtgembadep->npk_pic_sub != null)
                        {{ $mgmtgembadep->npk_pic_sub }} - {{ $mgmtgembadep->nm_pic_sub }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Area</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mgmtgembadep->kd_area }}</td>
                    <td style="width: 10%;"><b>Lokasi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mgmtgembadep->lokasi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Detail</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mgmtgembadep->det_gemba }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgembadep->pict_gemba))
                        <p>
                          <img src="{{ $mgmtgembadep->pictGemba() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Countermeasure</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mgmtgembadep->cm_ket }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>CM Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgembadep->cm_pict))
                        <p>
                          <img src="{{ $mgmtgembadep->cmPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Status Close</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if ($mgmtgembadep->st_gemba === "T")
                        YES
                      @else
                        NO
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgembadep->dtcrea))
                        {{ $mgmtgembadep->creaby }} - {{ Auth::user()->namaByUsername($mgmtgembadep->creaby) }} - {{ \Carbon\Carbon::parse($mgmtgembadep->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $mgmtgembadep->creaby }} - {{ Auth::user()->namaByUsername($mgmtgembadep->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgembadep->dtmodi))
                        {{ $mgmtgembadep->modiby }} - {{ Auth::user()->namaByUsername($mgmtgembadep->modiby) }} - {{ \Carbon\Carbon::parse($mgmtgembadep->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $mgmtgembadep->modiby }} - {{ Auth::user()->namaByUsername($mgmtgembadep->modiby) }}
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
        @if (Auth::user()->can(['mgt-gembadep-create','mgt-gembadep-delete']) && $mgmtgembadep->checkEdit() === "T")
          @if (Auth::user()->can('mgt-gembadep-create'))
            <a class="btn btn-primary" href="{{ route('mgmtgembadeps.edit', base64_encode($mgmtgembadep->no_gemba)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can('mgt-gembadep-delete'))
            <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('mgmtgembadeps.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Daftar Genba DEP">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#btn-delete").click(function(){
    var no_gemba = "{{ $mgmtgembadep->no_gemba }}";
    var msg = 'Anda yakin menghapus No. Genba: ' + no_gemba;
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
      var urlRedirect = "{{ route('mgmtgembadeps.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_gemba));
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