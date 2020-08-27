@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Master Rate MP
        <small>Detail Master Rate MP</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - Master</li>
        <li><a href="{{ route('bgttcrrates.index') }}"><i class="fa fa-files-o"></i> Rate MP</a></li>
        <li class="active">Detail Rate MP {{ $bgttcrrate->thn_period }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Master Rate</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>Tahun Periode</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrrate->thn_period }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Rate</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>Rp. {{ numberFormatter(0, 2)->format($bgttcrrate->rate_mp) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ $bgttcrrate->creaby }} - {{ $bgttcrrate->namaByNpk($bgttcrrate->creaby) }} - {{ \Carbon\Carbon::parse($bgttcrrate->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($bgttcrrate->dtmodi))
                    <tr>
                      <td style="width: 10%;"><b>Modiby</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        {{ $bgttcrrate->modiby }} - {{ $bgttcrrate->namaByNpk($bgttcrrate->modiby) }} - {{ \Carbon\Carbon::parse($bgttcrrate->dtmodi)->format('d/m/Y H:i') }}
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
        @if ($bgttcrrate->checkEdit() === "T")
          @if (Auth::user()->can('budget-cr-rate-create'))
            <a class="btn btn-primary" href="{{ route('bgttcrrates.edit', base64_encode($bgttcrrate->thn_period)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
            &nbsp;&nbsp;
          @endif
          @if (Auth::user()->can('budget-cr-rate-delete'))
            <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('bgttcrrates.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Master Rate" id="btn-cancel">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  $("#btn-delete").click(function(){
    var thn_period = "{{ $bgttcrrate->thn_period }}";
    var msg = 'Anda yakin menghapus Master Rate MP Tahun Periode: ' + thn_period + '?';
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
      var urlRedirect = "{{ route('bgttcrrates.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(thn_period));
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