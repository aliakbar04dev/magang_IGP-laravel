@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Kategori
        <small>Detail Master Kategori</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - Master</li>
        <li><a href="{{ route('bgttcrkategors.index') }}"><i class="fa fa-files-o"></i> Kategori</a></li>
        <li class="active">Detail Kategori {{ $bgttcrkategor->nm_kategori }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Master Kategori</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>Kategori</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrkategor->nm_kategori }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Klasifikasi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrkategor->nm_klasifikasi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Aktif</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($bgttcrkategor->st_aktif === "T")
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
                      {{ $bgttcrkategor->creaby }} - {{ \Auth::user()->namaByNpk($bgttcrkategor->creaby) }} - {{ \Carbon\Carbon::parse($bgttcrkategor->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($bgttcrkategor->dtmodi))
                    <tr>
                      <td style="width: 10%;"><b>Modiby</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        {{ $bgttcrkategor->modiby }} - {{ \Auth::user()->namaByNpk($bgttcrkategor->modiby) }} - {{ \Carbon\Carbon::parse($bgttcrkategor->dtmodi)->format('d/m/Y H:i') }}
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
        @if (Auth::user()->can('budget-cr-kategori-create'))
          <a class="btn btn-primary" href="{{ route('bgttcrkategors.edit', base64_encode($bgttcrkategor->nm_kategori)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
          &nbsp;&nbsp;
        @endif
        @if (Auth::user()->can('budget-cr-kategori-delete'))
          <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
          &nbsp;&nbsp;
        @endif
        <a class="btn btn-primary" href="{{ route('bgttcrkategors.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Master Kategori" id="btn-cancel">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $("#btn-delete").click(function(){
    var nm_kategori = "{{ $bgttcrkategor->nm_kategori }}";
    var msg = 'Anda yakin menghapus Master Kategori: ' + nm_kategori + '?';
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
      var urlRedirect = "{{ route('bgttcrkategors.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(nm_kategori));
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