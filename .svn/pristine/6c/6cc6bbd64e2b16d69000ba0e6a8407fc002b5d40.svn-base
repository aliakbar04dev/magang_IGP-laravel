@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Genba BOD
        <small>Detail Genba BOD</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MANAGEMENT - Transaksi</li>
        <li><a href="{{ route('mgmtgembas.index') }}"><i class="fa fa-files-o"></i> Daftar Genba BOD</a></li>
        <li class="active">Detail {{ $mgmtgemba->no_gemba }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Genba BOD</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mgmtgemba->no_gemba }}</td>
                    <td style="width: 10%;"><b>Tgl Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mgmtgemba->tgl_gemba)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">
                      @if ($mgmtgemba->kd_site === "IGPJ")
                        IGP - JAKARTA
                      @elseif ($mgmtgemba->kd_site === "IGPK")
                        IGP - KARAWANG
                      @else 
                        {{ $mgmtgemba->kd_site }}
                      @endif
                    </td>
                    <td style="width: 10%;"><b>PIC Genba</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mgmtgemba->npk_pic }} - {{ $mgmtgemba->initial }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Area</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mgmtgemba->kd_area }}</td>
                    <td style="width: 10%;"><b>Lokasi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mgmtgemba->lokasi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Detail</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mgmtgemba->det_gemba }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgemba->pict_gemba))
                        <p>
                          <img src="{{ $mgmtgemba->pictGemba() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Countermeasure</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mgmtgemba->cm_ket }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>CM Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgemba->cm_pict))
                        <p>
                          <img src="{{ $mgmtgemba->cmPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Status Close</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if ($mgmtgemba->st_gemba === "T")
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
                      @if (!empty($mgmtgemba->dtcrea))
                        {{ $mgmtgemba->creaby }} - {{ Auth::user()->namaByUsername($mgmtgemba->creaby) }} - {{ \Carbon\Carbon::parse($mgmtgemba->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $mgmtgemba->creaby }} - {{ Auth::user()->namaByUsername($mgmtgemba->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mgmtgemba->dtmodi))
                        {{ $mgmtgemba->modiby }} - {{ Auth::user()->namaByUsername($mgmtgemba->modiby) }} - {{ \Carbon\Carbon::parse($mgmtgemba->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $mgmtgemba->modiby }} - {{ Auth::user()->namaByUsername($mgmtgemba->modiby) }}
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
        @if (Auth::user()->can(['mgt-gemba-create','mgt-gemba-delete']) && $mgmtgemba->checkEdit() === "T")
          @if (Auth::user()->can('mgt-gemba-create'))
            <a class="btn btn-primary" href="{{ route('mgmtgembas.edit', base64_encode($mgmtgemba->no_gemba)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can('mgt-gemba-delete'))
            <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('mgmtgembas.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Daftar Genba BOD">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#btn-delete").click(function(){
    var no_gemba = "{{ $mgmtgemba->no_gemba }}";
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
      var urlRedirect = "{{ route('mgmtgembas.delete', 'param') }}";
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