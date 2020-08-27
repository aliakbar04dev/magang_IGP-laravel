@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PIC Ijin Kerja
        <small>Detail PIC Ijin Kerja</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> EHS - Master</li>
        <li><a href="{{ route('ehsmwppics.index') }}"><i class="fa fa-files-o"></i> PIC Ijin Kerja</a></li>
        <li class="active">Detail {{ $ehsmwppic->npk }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Pengisian Oli</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 5%;"><b>Npk</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ehsmwppic->npk }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Nama</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ehsmwppic->nama }}</td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Bagian</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ehsmwppic->bagian }}</td>
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
        @if (Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc']))
          <a class="btn btn-primary" href="{{ route('ehsmwppics.edit', base64_encode($ehsmwppic->npk)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
          &nbsp;&nbsp;
        @endif
        @if (Auth::user()->can(['ehs-wp-approve-prc','ehs-wp-reject-prc']))
          <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
          &nbsp;&nbsp;
        @endif
        <a class="btn btn-primary" href="{{ route('ehsmwppics.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard PIC Ijin Kerja" id="btn-cancel">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $("#btn-delete").click(function(){
    var npk = "{{ $ehsmwppic->npk }}";
    var msg = 'Anda yakin menghapus PIC Ijin Kerja: ' + npk + '?';
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
      var urlRedirect = "{{ route('ehsmwppics.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(npk));
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