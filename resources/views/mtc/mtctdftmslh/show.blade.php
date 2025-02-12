@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Masalah
        <small>Detail Daftar Masalah</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('mtctdftmslhs.index') }}"><i class="fa fa-files-o"></i> Daftar Masalah</a></li>
        <li class="active">Detail {{ $mtctdftmslh->no_dm }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar Masalah</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. DM</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mtctdftmslh->no_dm }}</td>
                    <td style="width: 10%;"><b>Tgl DM</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($mtctdftmslh->tgl_dm)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $mtctdftmslh->kd_site }}</td>
                    <td style="width: 10%;"><b>Plant</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $mtctdftmslh->kd_plant }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Line</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->kd_line }} - {{ $mtctdftmslh->nm_line }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Mesin</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->kd_mesin }} - {{ $mtctdftmslh->nm_mesin }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Problem</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_prob }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Counter Measure</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_cm }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Spare Part</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_sp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Evaluasi Hasil</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_eva_hasil }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Remain</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_remain }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Remark</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $mtctdftmslh->ket_remark }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->lok_pict))
                        <p>
                          <img src="{{ $mtctdftmslh->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. PI</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $mtctdftmslh->no_pi }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. LP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->tmtcwo1()))
                        @if (Auth::user()->can(['mtc-lp-*','mtc-apr-pic-lp','mtc-apr-sh-lp']))
                          <a href="{{ route('tmtcwo1s.show', base64_encode($mtctdftmslh->tmtcwo1()->no_wo)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail LP {{ $mtctdftmslh->tmtcwo1()->no_wo }}">{{ $mtctdftmslh->tmtcwo1()->no_wo }}</a>
                        @else
                          {{ $mtctdftmslh->tmtcwo1()->no_wo }}
                        @endif
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->kd_dep))
                        {{ $mtctdftmslh->kd_dep }} - {{ $mtctdftmslh->desc_dep }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->dtcrea))
                        {{ $mtctdftmslh->creaby }} - {{ $mtctdftmslh->nama($mtctdftmslh->creaby) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $mtctdftmslh->creaby }} - {{ $mtctdftmslh->nama($mtctdftmslh->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->dtmodi))
                        {{ $mtctdftmslh->modiby }} - {{ $mtctdftmslh->nama($mtctdftmslh->modiby) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $mtctdftmslh->modiby }} - {{ $mtctdftmslh->nama($mtctdftmslh->modiby) }}
                      @endif
                    </td>
                  </tr>
                  @if (!empty($mtctdftmslh->submit_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Submit DM</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->submit_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->submit_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->submit_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($mtctdftmslh->apr_pic_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Approve PIC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->apr_pic_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->apr_pic_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->apr_pic_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($mtctdftmslh->apr_fm_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Approve Foreman</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->apr_fm_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->apr_fm_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->apr_fm_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($mtctdftmslh->rjt_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $mtctdftmslh->rjt_npk }} - {{ $mtctdftmslh->nama($mtctdftmslh->rjt_npk) }} - {{ \Carbon\Carbon::parse($mtctdftmslh->rjt_tgl)->format('d/m/Y H:i') }} - {{ $mtctdftmslh->rjt_st }} - {{ $mtctdftmslh->rjt_ket }}
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 13%;"><b>Tgl Plan Pengerjaan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($mtctdftmslh->tgl_plan_mulai))
                        {{ \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_mulai)->format('d/m/Y H:i') }} - {{ \Carbon\Carbon::parse($mtctdftmslh->tgl_plan_selesai)->format('d/m/Y H:i') }}
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
        @if ($mtctdftmslh->submit_tgl == null)
          @if (Auth::user()->can(['mtc-dm-create','mtc-dm-delete']) && $mtctdftmslh->checkEdit() === "T")
            @if (Auth::user()->can('mtc-dm-create'))
              <a class="btn btn-primary" href="{{ route('mtctdftmslhs.edit', base64_encode($mtctdftmslh->no_dm)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('mtc-dm-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
          @endif
        @elseif($mtctdftmslh->submit_tgl != null)
          @if (Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm']))
            @if (empty($mtctdftmslh->apr_pic_tgl) && Auth::user()->can('mtc-apr-pic-dm'))
              <a class="btn btn-primary" href="{{ route('mtctdftmslhs.edit', base64_encode($mtctdftmslh->no_dm)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve DM - PIC {{ $mtctdftmslh->no_dm }}' onclick='approve("{{ $mtctdftmslh->no_dm }}","PIC")'>
                <span class='glyphicon glyphicon-check'></span> Approve DM - PIC
              </button>
              &nbsp;&nbsp;
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject DM - PIC {{ $mtctdftmslh->no_dm }}' onclick='reject("{{ $mtctdftmslh->no_dm }}","PIC")'>
                <span class='glyphicon glyphicon-remove'></span> Reject DM - PIC
              </button>
              &nbsp;&nbsp;
            @elseif(empty($mtctdftmslh->apr_fm_tgl) && Auth::user()->can('mtc-apr-fm-dm'))
              <a class="btn btn-primary" href="{{ route('mtctdftmslhs.edit', base64_encode($mtctdftmslh->no_dm)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve DM - Foreman {{ $mtctdftmslh->no_dm }}' onclick='approve("{{ $mtctdftmslh->no_dm }}","FM")'>
                <span class='glyphicon glyphicon-check'></span> Approve DM - Foreman
              </button>
              &nbsp;&nbsp;
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject DM - Foreman {{ $mtctdftmslh->no_dm }}' onclick='reject("{{ $mtctdftmslh->no_dm }}","FM")'>
                <span class='glyphicon glyphicon-remove'></span> Reject DM - Foreman
              </button>
              &nbsp;&nbsp;
            @elseif(empty($mtctdftmslh->tmtcwo1()) && Auth::user()->can('mtc-apr-fm-dm'))
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject DM - Foreman {{ $mtctdftmslh->no_dm }}' onclick='reject("{{ $mtctdftmslh->no_dm }}","FM")'>
                <span class='glyphicon glyphicon-remove'></span> Reject DM - Foreman
              </button>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('mtctdftmslhs.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard DM">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function approve(no_dm, status)
  {
    var msg = 'Anda yakin APPROVE No. DM ' + no_dm + '?';
    if(status === "PIC") {
      msg = 'Anda yakin APPROVE (PIC) No. DM ' + no_dm + '?';
    } else if(status === "FM") {
      msg = 'Anda yakin APPROVE (Foreman) No. DM ' + no_dm + '?';
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
      var url = "{{ route('mtctdftmslhs.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_dm          : window.btoa(no_dm),
          status_approve : window.btoa(status)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('mtctdftmslhs.show', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(no_dm));
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

  function reject(no_dm, status)
  {
    var msg = 'Anda yakin REJECT No. DM ' + no_dm + '?';
    if(status === "PIC") {
      msg = 'Anda yakin REJECT (PIC) No. DM ' + no_dm + '?';
    } else if(status === "FM") {
      msg = 'Anda yakin REJECT (Foreman) No. DM ' + no_dm + '?';
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
        var url = "{{ route('mtctdftmslhs.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_dm             : window.btoa(no_dm),
            status_reject     : window.btoa(status),
            keterangan_reject : result,
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('mtctdftmslhs.show', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_dm));
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

  $("#btn-delete").click(function(){
    var no_dm = "{{ $mtctdftmslh->no_dm }}";
    var msg = 'Anda yakin menghapus No. DM ' + no_dm;
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
      var urlRedirect = "{{ route('mtctdftmslhs.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_dm));
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