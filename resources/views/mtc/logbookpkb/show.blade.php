@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Kebutuhan Spare Parts Plant
        <small>Detail Kebutuhan Spare Parts Plant</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('mtctlogpkbs.index') }}"><i class="fa fa-files-o"></i> Kebutuhan Spare Parts Plant</a></li>
        <li class="active">Detail {{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Kebutuhan Spare Parts Plant</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>Tanggal</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') }}</td>
                    <td style="width: 10%;"><b>Pembuat</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctlogpkb->creaby." - ".$mtctlogpkb->nm_creaby }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Plant</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $mtctlogpkb->kd_plant }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Item</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mtctlogpkb->kd_item }}</td>
                    <td style="width: 10%;"><b>Nama Item</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctlogpkb->nm_item }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Nama Barang</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $mtctlogpkb->nm_brg }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Nama Type</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $mtctlogpkb->nm_type }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Nama Merk</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $mtctlogpkb->nm_merk }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Qty</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ numberFormatter(0, 2)->format($mtctlogpkb->qty) }}</td>
                    <td style="width: 10%;"><b>Satuan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctlogpkb->kd_sat }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Keterangan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctlogpkb->ket_mesin_line }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Dok. Ref</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mtctlogpkb->dok_ref_ket }}</td>
                    <td style="width: 10%;"><b>No. Referensi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctlogpkb->no_dok }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctlogpkb->lok_pict))
                        <p>
                          <img src="{{ $mtctlogpkb->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  @if (!empty($mtctlogpkb->tgl_cek))
                    <tr>
                      <td style="width: 12%;"><b>Approve</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctlogpkb->npk_cek }} - {{ $mtctlogpkb->nama($mtctlogpkb->npk_cek) }} - {{ \Carbon\Carbon::parse($mtctlogpkb->tgl_cek)->format('d/m/Y H:i') }}
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
        @if ($mtctlogpkb->tgl_cek == null)
          @if (Auth::user()->can(['mtc-lp-create','mtc-lp-delete']) && $mtctlogpkb->checkEdit() === "T")
            @if (Auth::user()->can('mtc-lp-create'))
              <a class="btn btn-primary" href="{{ route('mtctlogpkbs.edit', base64_encode(\Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis'))) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('mtc-lp-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('mtc-apr-logpkb'))
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve {{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') }}' onclick='approve("{{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis') }}","{{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') }}")'>
                <span class='glyphicon glyphicon-check'></span> Approve Kebutuhan Spare Parts Plant
              </button>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('mtctlogpkbs.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Kebutuhan Spare Parts Plant">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function approve(id, dtcrea)
  {
    var msg = 'Anda yakin Approve data: ' + dtcrea + '?';
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
      var token = document.getElementsByName('_token')[0].value.trim();
      // save via ajax
      // create data detail dengan ajax
      var url = "{{ route('mtctlogpkbs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          id             : window.btoa(id)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('mtctlogpkbs.show', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(id));
            window.location.href = urlRedirect;
          } else {
            swal("Cancelled", data.message, "error");
          }
        }, error:function(){ 
          $("#loading").hide();
          swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
        }
      });
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

  $("#btn-delete").click(function(){
    var id = "{{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('dmYHis') }}";
    var dtcrea = "{{ \Carbon\Carbon::parse($mtctlogpkb->dtcrea)->format('d/m/Y H:i:s') }}";
    var msg = 'Anda yakin menghapus data: ' + dtcrea;
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
      var urlRedirect = "{{ route('mtctlogpkbs.delete', 'param') }}";
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