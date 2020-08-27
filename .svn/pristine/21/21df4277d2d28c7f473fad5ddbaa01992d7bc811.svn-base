@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Pekerjaan
        <small>Detail Laporan Pekerjaan</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Transaksi</li>
        <li><a href="{{ route('tmtcwo1s.index') }}"><i class="fa fa-files-o"></i> Laporan Pekerjaan</a></li>
        <li class="active">Detail {{ $tmtcwo1->no_wo }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Laporan Pekerjaan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. LP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $tmtcwo1->no_wo }}</td>
                    <td style="width: 10%;"><b>Tgl LP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($tmtcwo1->tgl_wo)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Info Kerja</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $tmtcwo1->info_kerja }}</td>
                    <td style="width: 10%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $tmtcwo1->st_close_desc }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Site</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $tmtcwo1->kd_site }}</td>
                    <td style="width: 10%;"><b>Plant</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $tmtcwo1->lok_pt }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Shift</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $tmtcwo1->shift }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Line</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $tmtcwo1->kd_line }} - {{ $tmtcwo1->nm_line }}</td>
                    <td style="width: 10%;"><b>Mesin</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $tmtcwo1->kd_mesin }} - {{ $tmtcwo1->nm_mesin }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Problem</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $tmtcwo1->uraian_prob }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Penyebab</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $tmtcwo1->uraian_penyebab }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Counter Measure</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $tmtcwo1->langkah_kerja }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Est.Pengerjaan (Mulai)</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ \Carbon\Carbon::parse($tmtcwo1->est_jamstart)->format('d/m/Y H:i:s') }}</td>
                    <td style="width: 10%;"><b>Est.Pengerjaan (Selesai)</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($tmtcwo1->est_jamend)->format('d/m/Y H:i:s') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Jumlah Menit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ numberFormatter(0, 2)->format($tmtcwo1->est_durasi) }}</td>
                    <td style="width: 10%;"><b>Line Stop</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ numberFormatter(0, 2)->format($tmtcwo1->line_stop) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Pelaksana</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $tmtcwo1->nm_pelaksana }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Keterangan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $tmtcwo1->catatan }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Main Item</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">
                      @if($tmtcwo1->st_main_item === "T") 
                        YA
                      @else 
                        TIDAK
                      @endif
                    </td>
                    <td style="width: 10%;"><b>IC</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($tmtcwo1->no_ic))
                        {{ $tmtcwo1->no_ic }} - {{ $tmtcwo1->nm_ic }} 
                        @if ($tmtcwo1->lastNoPms() != null)
                          &nbsp;&nbsp;
                          <button id="btnis" type="button" class="btn btn-xs btn-warning" data-toggle="modal" data-target="#isModal" onclick="popupIs('{{ base64_encode($tmtcwo1->lastNoPms()->no_pms) }}', '{{ base64_encode($tmtcwo1->pictPms()) }}', '{{ base64_encode($tmtcwo1->lastNoPms()->periode_pms) }}')"><span class="glyphicon glyphicon-eye-open"></span></button>
                        @endif
                      @endif
                    </td>
                  </tr>
                  @if (!empty($tmtcwo1->no_lhp))
                    <td style="width: 12%;"><b>No. LHP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $tmtcwo1->no_lhp }}</td>
                    <td style="width: 10%;"><b>LS Mulai</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($tmtcwo1->ls_mulai)->format('d/m/Y H:i:s') }}</td>
                  @endif
                  <tr>
                    <td style="width: 12%;"><b>Picture</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($tmtcwo1->lok_pict))
                        <p>
                          <img src="{{ $tmtcwo1->lokPict() }}" alt="File Not Found" class="img-rounded img-responsive">
                        </p>
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. PMS</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $tmtcwo1->no_pms }}</td>
                    <td style="width: 10%;"><b>No. DM</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if (!empty($tmtcwo1->no_dm))
                        @if (Auth::user()->can(['mtc-dm-*','mtc-apr-pic-dm','mtc-apr-fm-dm']))
                          <a href="{{ route('mtctdftmslhs.show', base64_encode($tmtcwo1->no_dm)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail DM {{ $tmtcwo1->no_dm }}">{{ $tmtcwo1->no_dm }}</a>
                        @else
                          {{ $tmtcwo1->no_dm }}
                        @endif
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($tmtcwo1->dtcrea))
                        {{ $tmtcwo1->creaby }} - {{ $tmtcwo1->nama($tmtcwo1->creaby) }} - {{ \Carbon\Carbon::parse($tmtcwo1->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $tmtcwo1->creaby }} - {{ $tmtcwo1->nama($tmtcwo1->creaby) }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($tmtcwo1->dtmodi))
                        {{ $tmtcwo1->modiby }} - {{ $tmtcwo1->nama($tmtcwo1->modiby) }} - {{ \Carbon\Carbon::parse($tmtcwo1->dtmodi)->format('d/m/Y H:i') }}
                      @else
                        {{ $tmtcwo1->modiby }} - {{ $tmtcwo1->nama($tmtcwo1->modiby) }}
                      @endif
                    </td>
                  </tr>
                  @if (!empty($tmtcwo1->apr_pic_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Approve PIC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $tmtcwo1->apr_pic_npk }} - {{ $tmtcwo1->nama($tmtcwo1->apr_pic_npk) }} - {{ \Carbon\Carbon::parse($tmtcwo1->apr_pic_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($tmtcwo1->apr_sh_tgl))
                    <tr>
                      <td style="width: 12%;"><b>Approve Section</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $tmtcwo1->apr_sh_npk }} - {{ $tmtcwo1->nama($tmtcwo1->apr_sh_npk) }} - {{ \Carbon\Carbon::parse($tmtcwo1->apr_sh_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($tmtcwo1->rjt_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Reject</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $tmtcwo1->rjt_npk }} - {{ $tmtcwo1->nama($tmtcwo1->rjt_npk) }} - {{ \Carbon\Carbon::parse($tmtcwo1->rjt_tgl)->format('d/m/Y H:i') }} - {{ $tmtcwo1->rjt_st }} - {{ $tmtcwo1->rjt_ket }}
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
        @if ($tmtcwo1->st_close === "F")
          @if (Auth::user()->can(['mtc-lp-create','mtc-lp-delete']) && $tmtcwo1->checkEdit() === "T")
            @if (Auth::user()->can('mtc-lp-create'))
              <a class="btn btn-primary" href="{{ route('tmtcwo1s.edit', base64_encode($tmtcwo1->no_wo)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('mtc-lp-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
          @endif
        @elseif($tmtcwo1->st_close === "T")
          @if (Auth::user()->can(['mtc-apr-pic-lp','mtc-apr-sh-lp']))
            @if (empty($tmtcwo1->apr_pic_tgl) && Auth::user()->can('mtc-apr-pic-lp'))
              <a class="btn btn-primary" href="{{ route('tmtcwo1s.edit', base64_encode($tmtcwo1->no_wo)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve LP - PIC {{ $tmtcwo1->no_wo }}' onclick='approve("{{ $tmtcwo1->no_wo }}","PIC")'>
                <span class='glyphicon glyphicon-check'></span> Approve LP - PIC
              </button>
              &nbsp;&nbsp;
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject LP - PIC {{ $tmtcwo1->no_wo }}' onclick='reject("{{ $tmtcwo1->no_wo }}","PIC")'>
                <span class='glyphicon glyphicon-remove'></span> Reject LP - PIC
              </button>
              &nbsp;&nbsp;
            @elseif(empty($tmtcwo1->apr_sh_tgl) && Auth::user()->can('mtc-apr-sh-lp'))
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve LP - Section {{ $tmtcwo1->no_wo }}' onclick='approve("{{ $tmtcwo1->no_wo }}","SH")'>
                <span class='glyphicon glyphicon-check'></span> Approve LP - Section
              </button>
              &nbsp;&nbsp;
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject LP - Section {{ $tmtcwo1->no_wo }}' onclick='reject("{{ $tmtcwo1->no_wo }}","SH")'>
                <span class='glyphicon glyphicon-remove'></span> Reject LP - Section
              </button>
              &nbsp;&nbsp;
            @elseif(Auth::user()->can('mtc-apr-sh-lp'))
              <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject LP - Section {{ $tmtcwo1->no_wo }}' onclick='reject("{{ $tmtcwo1->no_wo }}","SH")'>
                <span class='glyphicon glyphicon-remove'></span> Reject LP - Section
              </button>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('tmtcwo1s.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard LP">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Modal IS -->
  @include('mtc.lp.popup.isModal')
@endsection

@section('scripts')
<script type="text/javascript">

  function approve(no_wo, status)
  {
    var msg = 'Anda yakin APPROVE No. LP ' + no_wo + '?';
    if(status === "PIC") {
      msg = 'Anda yakin APPROVE (PIC) No. LP ' + no_wo + '?';
    } else if(status === "SH") {
      msg = 'Anda yakin APPROVE (Section) No. LP ' + no_wo + '?';
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
      var url = "{{ route('tmtcwo1s.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_wo          : window.btoa(no_wo),
          status_approve : window.btoa(status)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('tmtcwo1s.show', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
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

  function reject(no_wo, status)
  {
    var msg = 'Anda yakin REJECT No. LP ' + no_wo + '?';
    if(status === "PIC") {
      msg = 'Anda yakin REJECT (PIC) No. LP ' + no_wo + '?';
    } else if(status === "SH") {
      msg = 'Anda yakin REJECT (Section) No. LP ' + no_wo + '?';
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
        var url = "{{ route('tmtcwo1s.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_wo             : window.btoa(no_wo),
            status_reject     : window.btoa(status),
            keterangan_reject : result,
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('tmtcwo1s.show', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_wo));
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
    var no_wo = "{{ $tmtcwo1->no_wo }}";
    var msg = 'Anda yakin menghapus No. LP ' + no_wo;
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
      var urlRedirect = "{{ route('tmtcwo1s.delete', 'param') }}";
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
  });

  $(document).ready(function(){

    var url = '{{ route('dashboardis2.mtctpmss', 'param') }}';
    url = url.replace('param', window.btoa("0"));
    var tblDetail = $('#tblDetail').DataTable({
      "searching": false,
      "ordering": false,
      "paging": false,
      "scrollX": true,
      "scrollY": "300px",
      "scrollCollapse": true,
      // responsive: true,
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url, 
      columns: [
        // {data: 'no_urut', name: 'no_urut', className: "dt-center", orderable: false, searchable: false},
        {data: 'nm_is', name: 'nm_is', orderable: false, searchable: false},
        {data: 'ketentuan', name: 'ketentuan', orderable: false, searchable: false},
        {data: 'metode', name: 'metode', orderable: false, searchable: false},
        {data: 'alat', name: 'alat', orderable: false, searchable: false},
        {data: 'waktu_menit', name: 'waktu_menit', className: "dt-right", orderable: false, searchable: false},
        {data: 'st_ok_ng', name: 'st_ok_ng', className: "dt-center", orderable: false, searchable: false},
        {data: 'ket_ng', name: 'ket_ng', orderable: false, searchable: false},
        {data: 'lok_pict', name: 'lok_pict', orderable: false, searchable: false}
      ], 
    });
  });

  function popupIs(no_pms, lok_pict, periode_pms) {
    var myHeading = "<p>Inspection Standard (No. PMS: " + window.atob(no_pms) + ", Tgl PMS: " + window.atob(periode_pms) + ")</p>";
    $("#isModalLabel").html(myHeading);

    if(window.atob(lok_pict) === "-") {
      $("#boxtitle").html("Foto (Tidak ada)");
      $('#lok_pict').attr('alt', "Tidak ada foto");
      $('#lok_pict').attr('src', "");
    } else {
      $("#boxtitle").html("Foto (Ada)");
      $('#lok_pict').attr('alt', "File Not Found");
      $('#lok_pict').attr('src', "data:image/jpg;charset=utf-8;base64," + lok_pict);
    }
    var tableDetail = $('#tblDetail').DataTable();
    var url = '{{ route('dashboardis2.mtctpmss', 'param') }}';
    url = url.replace('param', no_pms);
    tableDetail.ajax.url(url).load();
  }
</script>
@endsection