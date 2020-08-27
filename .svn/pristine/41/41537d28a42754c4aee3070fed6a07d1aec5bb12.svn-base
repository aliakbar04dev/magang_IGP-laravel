@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        DEPR
        <small>Detail Delivery Problem Report</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PPC - Transaksi</li>
        <li><a href="{{ route('ppctdprs.index') }}"><i class="fa fa-files-o"></i> Daftar DEPR</a></li>
        <li class="active">Detail {{ $ppctdpr->no_dpr }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">DEPR</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 15%;"><b>No. DEPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $ppctdpr->no_dpr }}</td>
                    <td style="width: 10%;"><b>Tgl DEPR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($ppctdpr->tgl_dpr)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $ppctdpr->kd_site }}</td>
                    <td style="width: 10%;"><b>Supplier</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ppctdpr->kd_bpid }} - {{ $ppctdpr->namaSupp($ppctdpr->kd_bpid) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Problem Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $ppctdpr->problem_st }}</td>
                  </tr>
                  @if (!empty($ppctdpr->problem_oth))
                    <tr>
                      <td style="width: 15%;"><b>Problem Others</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4" style="white-space:pre;">{{ $ppctdpr->problem_oth }}</td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 15%;"><b>Line Stop</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">
                      @if($ppctdpr->st_ls != null)
                        @if($ppctdpr->st_ls === "T")
                          YA
                        @else 
                          TIDAK
                        @endif
                      @endif
                    </td>
                    <td style="width: 10%;"><b>Jumlah Menit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if($ppctdpr->jml_ls_menit != null)
                        {{ numberFormatter(0, 2)->format($ppctdpr->jml_ls_menit) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Problem Tittle</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $ppctdpr->problem_title }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Problem Ket.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $ppctdpr->problem_ket }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Problem Standard</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $ppctdpr->problem_std }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Problem Actual</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $ppctdpr->problem_act }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($ppctdpr->problem_pict))
                        <p>
                          <img src="{{ $ppctdpr->problemPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($ppctdpr->opt_dtcrea))
                        {{ $ppctdpr->opt_creaby }} - {{ $ppctdpr->nama($ppctdpr->opt_creaby) }} - {{ \Carbon\Carbon::parse($ppctdpr->opt_dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $ppctdpr->opt_creaby }} - {{ $ppctdpr->nama($ppctdpr->opt_creaby) }}
                      @endif
                    </td>
                  </tr>
                  @if (!empty($ppctdpr->opt_dtsubmit))
                    <tr>
                      <td style="width: 15%;"><b>Submit DEPR</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdpr->opt_submit }} - {{ $ppctdpr->nama($ppctdpr->opt_submit) }} - {{ \Carbon\Carbon::parse($ppctdpr->opt_dtsubmit)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdpr->sh_dtaprov))
                    <tr>
                      <td style="width: 15%;"><b>Approve SH</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdpr->sh_aprov }} - {{ $ppctdpr->nama($ppctdpr->sh_aprov) }} - {{ \Carbon\Carbon::parse($ppctdpr->sh_dtaprov)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdpr->sh_dtreject))
                    <tr>
                      <td style="width: 13%;"><b>Reject SH</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdpr->sh_reject }} - {{ $ppctdpr->nama($ppctdpr->sh_reject) }} - {{ \Carbon\Carbon::parse($ppctdpr->sh_dtreject)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdpr->dh_dtaprov))
                    <tr>
                      <td style="width: 15%;"><b>Approve Dept. Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdpr->dh_aprov }} - {{ $ppctdpr->nama($ppctdpr->dh_aprov) }} - {{ \Carbon\Carbon::parse($ppctdpr->dh_dtaprov)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdpr->dh_dtreject))
                    <tr>
                      <td style="width: 13%;"><b>Reject Dept. Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdpr->dh_reject }} - {{ $ppctdpr->nama($ppctdpr->dh_reject) }} - {{ \Carbon\Carbon::parse($ppctdpr->dh_dtreject)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdpr->ppctDprPicas()))
                    <tr>
                      <td style="width: 13%;"><b>No. PICA</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        <a href="{{ route('ppctdprpicas.showall', base64_encode($ppctdpr->ppctDprPicas()->no_dpr)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DEPR {{ $ppctdpr->ppctDprPicas()->no_dpr }}">{{ $ppctdpr->ppctDprPicas()->no_dpr }}</a>
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
        @if ($ppctdpr->ppctDprPicas() == null)
          @if ($ppctdpr->opt_dtsubmit == null)
            @if (Auth::user()->can(['ppc-dpr-create','ppc-dpr-delete']) && $ppctdpr->checkEdit() === "T")
              @if (Auth::user()->can('ppc-dpr-create'))
                <a class="btn btn-primary" href="{{ route('ppctdprs.edit', base64_encode($ppctdpr->no_dpr)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
                &nbsp;&nbsp;
              @endif
              @if (Auth::user()->can('ppc-dpr-delete'))
                <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
                &nbsp;&nbsp;
              @endif
            @endif
          @elseif($ppctdpr->sh_dtaprov == null)
            @if (Auth::user()->can('ppc-dpr-apr-sh'))
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve DEPR - Section {{ $ppctdpr->no_dpr }}' onclick='approve("{{ $ppctdpr->no_dpr }}","SH")'>
                <span class='glyphicon glyphicon-check'></span> Approve DEPR - Section
              </button>
              &nbsp;&nbsp;
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject DEPR - Section {{ $ppctdpr->no_dpr }}' onclick='reject("{{ $ppctdpr->no_dpr }}","SH")'>
                <span class='glyphicon glyphicon-remove'></span> Reject DEPR - Section
              </button>
              &nbsp;&nbsp;
            @endif
          @elseif($ppctdpr->dh_dtaprov == null)
            @if (Auth::user()->can('ppc-dpr-apr-dh'))
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve DEPR - Dept. Head {{ $ppctdpr->no_dpr }}' onclick='approve("{{ $ppctdpr->no_dpr }}","DH")'>
                <span class='glyphicon glyphicon-check'></span> Approve DEPR - Dept. Head
              </button>
              &nbsp;&nbsp;
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject DEPR - Dept. Head {{ $ppctdpr->no_dpr }}' onclick='reject("{{ $ppctdpr->no_dpr }}","DH")'>
                <span class='glyphicon glyphicon-remove'></span> Reject DEPR - Dept. Head
              </button>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ url()->previous() }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard DEPR">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#btn-delete").click(function(){
    var no_dpr = "{{ $ppctdpr->no_dpr }}";
    var msg = 'Anda yakin menghapus No. DEPR: ' + no_dpr;
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
      var urlRedirect = "{{ route('ppctdprs.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_dpr));
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

  function approve(no_dpr, status)
  {
    var msg = 'Anda yakin APPROVE No. DEPR: ' + no_dpr + '?';
    if(status === "SH") {
      msg = 'Anda yakin APPROVE (Section) No. DEPR: ' + no_dpr + '?';
    } else if(status === "DH") {
      msg = 'Anda yakin APPROVE (Dept. Head) No. DEPR: ' + no_dpr + '?';
    }
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
      var url = "{{ route('ppctdprs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_dpr         : window.btoa(no_dpr),
          status_approve : window.btoa(status)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('ppctdprs.show', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(no_dpr));
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

  function reject(no_dpr, status)
  {
    var msg = 'Anda yakin REJECT No. DEPR: ' + no_dpr + '?';
    if(status === "SH") {
      msg = 'Anda yakin REJECT (Section) No. DEPR: ' + no_dpr + '?';
    } else if(status === "DH") {
      msg = 'Anda yakin REJECT (Dept. Head) No. DEPR: ' + no_dpr + '?';
    }
    //additional input validations can be done hear
    swal({
      title: msg,
      text: "",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, reject it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      swal({
        title: 'Input Keterangan Reject',
        input: 'textarea',
        showCancelButton: true,
        inputValidator: function (value) {
          return new Promise(function (resolve, reject) {
            if (value) {
              if(value.length > 200) {
                reject('Keterangan Reject Max 200 Karakter!')
              } else {
                resolve()
              }
            } else {
              reject('Keterangan Reject tidak boleh kosong!')
            }
          })
        }
      }).then(function (result) {
        var token = document.getElementsByName('_token')[0].value.trim();
        // save via ajax
        // create data detail dengan ajax
        var url = "{{ route('ppctdprs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_dpr            : window.btoa(no_dpr),
            status_reject     : window.btoa(status),
            keterangan_reject : result,
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('ppctdprs.show', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_dpr));
              window.location.href = urlRedirect;
            } else {
              swal("Cancelled", data.message, "error");
            }
          }, error:function(){ 
            $("#loading").hide();
            swal("System Error!", "Maaf, terjadi kesalahan pada system kami. Silahkan hubungi Administrator. Terima Kasih.", "error");
          }
        });
      }).catch(swal.noop)
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