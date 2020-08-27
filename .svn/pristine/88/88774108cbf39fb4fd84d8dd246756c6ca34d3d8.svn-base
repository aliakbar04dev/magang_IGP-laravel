@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Mapping BPID
        <small>Detail Mapping BPID</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - MASTER - PO</li>
        <li><a href="{{ route('prctepobpids.index') }}"><i class="fa fa-files-o"></i> Mapping BPID</a></li>
        <li class="active">Detail {{ $prctepobpid->kd_bpid }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Mapping BPID</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>BPID</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctepobpid->kd_bpid }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Nama BPID</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctepobpid->nm_bpid }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>BPID Others</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctepobpid->nm_oth }}</td>
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
        @if (Auth::user()->can('prc-po-setting-npk'))
          <a class="btn btn-primary" href="{{ route('prctepobpids.edit', base64_encode($prctepobpid->kd_bpid)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
          &nbsp;&nbsp;
          <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
          &nbsp;&nbsp;
        @endif
        <a class="btn btn-primary" href="{{ route('prctepobpids.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Mapping BPID" id="btn-cancel">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $("#btn-delete").click(function(){
    var kd_bpid = "{{ $prctepobpid->kd_bpid }}";
    var msg = 'Anda yakin menghapus Mapping BPID: ' + kd_bpid + '?';
    var txt = '';
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
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
      var urlRedirect = "{{ route('prctepobpids.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(kd_bpid));
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