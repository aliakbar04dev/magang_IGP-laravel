@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Simbol PFC
        <small>Detail Simbol PFC</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> ENGINEERING - MASTER</li>
        <li><a href="{{ route('engtmsimbols.index') }}"><i class="fa fa-files-o"></i> Simbol PFC</a></li>
        <li class="active">Detail {{ $engtmsimbol->ket }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Simbol PFC</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 5%;"><b>Keterangan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $engtmsimbol->ket }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($lokfile))
                        <p>
                          <img src="{{ $lokfile }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($engtmsimbol->dtcrea))
                        {{ $engtmsimbol->creaby }} - {{ Auth::user()->namaByUsername($engtmsimbol->creaby) }} - {{ \Carbon\Carbon::parse($engtmsimbol->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $engtmsimbol->creaby }} - {{ Auth::user()->namaByUsername($engtmsimbol->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 5%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($engtmsimbol->dtmodi))
                        {{ $engtmsimbol->modiby }} - {{ Auth::user()->namaByUsername($engtmsimbol->modiby) }} - {{ \Carbon\Carbon::parse($engtmsimbol->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $engtmsimbol->modiby }} - {{ Auth::user()->namaByUsername($engtmsimbol->modiby) }}
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
        @if (Auth::user()->can(['eng-pfcsimbol-create','eng-pfcsimbol-delete']))
          @if (Auth::user()->can('eng-pfcsimbol-create'))
            <a class="btn btn-primary" href="{{ route('engtmsimbols.edit', base64_encode($engtmsimbol->id)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can('eng-pfcsimbol-delete') && $engtmsimbol->cek != "T")
            <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('engtmsimbols.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Daftar Simbol PFC">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $("#btn-delete").click(function(){
    var ket = "{{ $engtmsimbol->ket }}";
    var id = "{{ $engtmsimbol->id }}";
    var msg = 'Anda yakin menghapus Simbol: ' + ket + '?';
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
      var urlRedirect = "{{ route('engtmsimbols.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(id));
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