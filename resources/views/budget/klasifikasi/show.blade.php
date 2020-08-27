@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Klasifikasi
        <small>Detail Master Klasifikasi</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - Master</li>
        <li><a href="{{ route('bgttcrklasifis.index') }}"><i class="fa fa-files-o"></i> Klasifikasi</a></li>
        <li class="active">Detail Klasifikasi {{ $bgttcrklasifi->nm_klasifikasi }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Master Klasifikasi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>Nama</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrklasifi->nm_klasifikasi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Aktif</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($bgttcrklasifi->st_aktif === "T")
                        YA
                      @else 
                        TIDAK
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ $bgttcrklasifi->creaby }} - {{ $bgttcrklasifi->namaByNpk($bgttcrklasifi->creaby) }} - {{ \Carbon\Carbon::parse($bgttcrklasifi->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($bgttcrklasifi->dtmodi))
                    <tr>
                      <td style="width: 10%;"><b>Modiby</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        {{ $bgttcrklasifi->modiby }} - {{ $bgttcrklasifi->namaByNpk($bgttcrklasifi->modiby) }} - {{ \Carbon\Carbon::parse($bgttcrklasifi->dtmodi)->format('d/m/Y H:i') }}
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
      <div class="box-footer">
        @if ($bgttcrklasifi->checkEdit() === "T")
          @if (Auth::user()->can('budget-cr-klasifikasi-create'))
            <a class="btn btn-primary" href="{{ route('bgttcrklasifis.edit', base64_encode($bgttcrklasifi->nm_klasifikasi)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can('budget-cr-klasifikasi-delete'))
            <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('bgttcrklasifis.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Master Klasifikasi" id="btn-cancel">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $("#btn-delete").click(function(){
    var nm_klasifikasi = "{{ $bgttcrklasifi->nm_klasifikasi }}";
    var msg = 'Anda yakin menghapus Master Klasifikasi: ' + nm_klasifikasi + '?';
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
      var urlRedirect = "{{ route('bgttcrklasifis.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(nm_klasifikasi));
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