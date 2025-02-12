@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Work Order
        <small>Detail Work Order</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('wos.index') }}"><i class="fa fa-files-o"></i> Daftar Work Order</a></li>
        <li class="active">Detail {{ $wo->no_wo }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Work Order</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. WO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $wo->no_wo }}</td>
                    <td style="width: 10%;"><b>Tgl WO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($wo->tgl_wo)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>PT</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                        @if ($wo->kd_pt == "WEP")
                          {{ "PT WAHANA EKA PRAMITRA" }}
                        @else 
                        {{ "PT INTI GANDA PERDANA" }}
                        @endif
                    </td>                    
                    <td style="width: 12%;"><b>Bagian</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td >{{ $wo->namaDepartemen($wo->kd_dep) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>EXT</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $wo->ext }}</td> 
                    <td style="width: 12%;"><b>ID Hardware</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $wo->id_hw }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Permintaan/Problem</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $wo->jenis_orders }} - {{ $wo->detail_orders }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Penjelasan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $wo->uraian }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Tanggal Terima</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $wo->tgl_terima }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>PIC Terima</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $wo->pic_terima }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Tanggal Solusi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $wo->tgl_selesai }}</td>
                  </tr>
                   <tr>
                    <td style="width: 12%;"><b>PIC Solusi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $wo->pic_solusi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Penanganan/Solusi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $wo->jenis_solusi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b></b></td>
                    <td style="width: 1%;"><b></b></td>
                    <td colspan="4" style="white-space:pre;">{{$wo->solusi}}</td>
                  </tr> 
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($wo->dtcrea))
                        {{ $wo->creaby }} - {{ $wo->nama($wo->creaby) }} - {{ \Carbon\Carbon::parse($wo->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $wo->creaby }} - {{ $wo->nama($wo->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($wo->dtmodi))
                        {{ $wo->modiby }} - {{ $wo->nama($wo->modiby) }} - {{ \Carbon\Carbon::parse($wo->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $wo->modiby }} - {{ $wo->nama($wo->modiby) }}
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
      @if ($wo->statusapp === "SUBMIT")
          @if (Auth::user()->masKaryawan()->kode_dep === "H5")
            <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve WO {{ $wo->no_wo }}' onclick='approve("{{ $wo->no_wo }}", "SUBMIT")'>
              <span class='glyphicon glyphicon-check'></span> Approve 
            </button>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->masKaryawan()->kode_dep === "H5")
              <button id='btnunapprove' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Unapprove WO {{ $wo->no_wo }}' 

              ='unapprove("{{ $wo->no_wo }}", "SUBMIT")'>
              <span class='glyphicon glyphicon-repeat'></span> Unapprove
            </button>
            &nbsp;&nbsp;
          @endif
      @endif
      @if ($wo->statusapp === "DITERIMA")
         <a class="btn btn-primary" href="{{ route('wos.index'), ['param','param2'] }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard DM">Tambahkan Solusi</a>
      @endif
       @if ($wo->statusapp === "TIDAK DITERIMA")
         <a class="btn btn-primary" href="{{ route('wos.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard DM">Tambahkan Alasan</a>
      @endif
        <a class="btn btn-primary" href="{{ route('wos.index' ) }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard DM">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  function approve(no_wo, statusapp)
  {
    var msg = 'Anda yakin APPROVE No. WO ' + no_wo;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('wos.approve', ['param','param2'] ) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
      urlRedirect = urlRedirect.replace('param2', window.btoa(statusapp));
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
  }

  function unapprove(no_wo, statusapp)
  {
    var msg = 'Anda yakin tidak APPROVE No. WO ' + no_wo;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('wos.unapprove', ['param','param2'] ) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
      urlRedirect = urlRedirect.replace('param2', window.btoa(statusapp));
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
  }

  function itselesai(no_wo)
  {
    var msg = 'Anda yakin APPROVE No. WO ' + no_wo;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, approve it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('wos.itselesai', ['param'] ) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
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
  }
</script>
@endsection