@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        SSR
        <small>Detail Supplier Selection Request</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - SSR</li>
        <li><a href="{{ route('prctssr1s.index') }}"><i class="fa fa-files-o"></i> Daftar SSR</a></li>
        <li class="active">Detail {{ $prctssr1->no_ssr }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">SSR</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 15%;"><b>No. SSR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $prctssr1->no_ssr }}</td>
                    <td style="width: 10%;"><b>Tgl SSR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($prctssr1->tgl_ssr)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Model</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $prctssr1->nm_model }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Drawing No. / Part No.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $prctssr1->nm_drawing }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Due Date of Quotation</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ \Carbon\Carbon::parse($prctssr1->dd_quot)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Supporting Document</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $prctssr1->support_doc }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Technical No.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $prctssr1->tech_no }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Volume Prod. / Years</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ numberFormatter(0, 2)->format($prctssr1->vol_prod_year) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Reason of Request</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $prctssr1->reason_of_req }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Start of Mass Prod.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ \Carbon\Carbon::parse($prctssr1->start_maspro)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Subcontractor References</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      1. {{ $prctssr1->subcont1 }}<br>
                      2. {{ $prctssr1->subcont2 }}<br>
                      3. {{ $prctssr1->subcont3 }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Exchange Rate</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      <table cellspacing="0" width="100%">
                        <tr>
                          <th style="width: 5%;text-align: center;">1 USD</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctssr1->er_usd) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 THB</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctssr1->er_thb) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 KRW</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctssr1->er_krw) }}</td>
                          <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;IDR</td>
                        </tr>
                        <tr>
                          <th style="width: 5%;text-align: center;">1 JPY</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctssr1->er_jpy) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 CNY</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctssr1->er_cny) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 EUR</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctssr1->er_eur) }}</td>
                          <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;IDR</td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 15%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      @if (!empty($prctssr1->dtcrea))
                        {{ $prctssr1->creaby }} - {{ $prctssr1->nama($prctssr1->creaby) }} - {{ \Carbon\Carbon::parse($prctssr1->dtcrea)->format('d/m/Y H:i') }}
                      @else
                        {{ $prctssr1->creaby }} - {{ $prctssr1->nama($prctssr1->creaby) }}
                      @endif
                    </td>
                  </tr>
                  @if (!empty($prctssr1->user_dtsubmit))
                    <tr>
                      <td style="width: 15%;"><b>Submit SSR</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctssr1->user_submit }} - {{ $prctssr1->nama($prctssr1->user_submit) }} - {{ \Carbon\Carbon::parse($prctssr1->user_dtsubmit)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($prctssr1->prc_dtaprov))
                    <tr>
                      <td style="width: 15%;"><b>Approve PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctssr1->prc_aprov }} - {{ $prctssr1->nama($prctssr1->prc_aprov) }} - {{ \Carbon\Carbon::parse($prctssr1->prc_dtaprov)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($prctssr1->prc_dtreject))
                    <tr>
                      <td style="width: 13%;"><b>Reject PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctssr1->prc_reject }} - {{ $prctssr1->nama($prctssr1->prc_reject) }} - {{ \Carbon\Carbon::parse($prctssr1->prc_dtreject)->format('d/m/Y H:i') }}
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
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail SSR {{ $prctssr1->no_ssr }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $prctssr1->no_ssr }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 10%;">Part No</th>
                    <th style="width: 25%;">Part Name</th>
                    <th style="width: 5%;">Vol./Month</th>
                    <th style="width: 5%;">QPU</th>
                    <th>Material</th>
                    <th style="width: 20%;">Condition</th>
                  </tr>
                </thead>
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
        @if ($prctssr1->user_dtsubmit == null)
          @if (Auth::user()->can(['prc-ssr-create','prc-ssr-delete']) && $prctssr1->checkEdit() === "T")
            @if (Auth::user()->can('prc-ssr-create'))
              <a class="btn btn-primary" href="{{ route('prctssr1s.edit', base64_encode($prctssr1->no_ssr)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
            @if (Auth::user()->can('prc-ssr-delete'))
              <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data">Hapus Data</button>
              &nbsp;&nbsp;
            @endif
          @endif
        @elseif($prctssr1->prc_dtaprov == null)
          @if (Auth::user()->can('prc-ssr-approve'))
            <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve SSR - PRC {{ $prctssr1->no_ssr }}' onclick='approve("{{ $prctssr1->no_ssr }}","PRC")'>
              <span class='glyphicon glyphicon-check'></span> Approve SSR - PRC
            </button>
            &nbsp;&nbsp;
            <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject SSR - PRC {{ $prctssr1->no_ssr }}' onclick='reject("{{ $prctssr1->no_ssr }}","PRC")'>
              <span class='glyphicon glyphicon-remove'></span> Reject SSR - PRC
            </button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('prctssr1s.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard SSR">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $("#btn-delete").click(function(){
    var no_ssr = "{{ $prctssr1->no_ssr }}";
    var msg = 'Anda yakin menghapus No. SSR: ' + no_ssr;
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
      var urlRedirect = "{{ route('prctssr1s.delete', 'param') }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_ssr));
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

  function approve(no_ssr, status)
  {
    var msg = 'Anda yakin APPROVE No. SSR: ' + no_ssr + '?';
    if(status === "PRC") {
      msg = 'Anda yakin APPROVE (PRC) No. SSR: ' + no_ssr + '?';
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
      var url = "{{ route('prctssr1s.approve')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          no_ssr         : window.btoa(no_ssr),
          status_approve : window.btoa(status)
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('prctssr1s.show', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa(no_ssr));
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

  function reject(no_ssr, status)
  {
    var msg = 'Anda yakin REJECT No. SSR: ' + no_ssr + '?';
    if(status === "PRC") {
      msg = 'Anda yakin REJECT (PRC) No. SSR: ' + no_ssr + '?';
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
        var url = "{{ route('prctssr1s.reject')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            no_ssr            : window.btoa(no_ssr),
            status_reject     : window.btoa(status),
            keterangan_reject : result,
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('prctssr1s.show', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa(no_ssr));
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

  $(document).ready(function(){
    var no_ssr = $('#field').data("field-id");
    var url = '{{ route('prctssr1s.detail', 'param') }}';    
    url = url.replace('param', window.btoa(no_ssr));
    var tableDetail = $('#tblDetail').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      responsive: true,
      "order": [[1, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'part_no', name: 'part_no'},
        { data: 'nm_part', name: 'nm_part'},
        { data: 'vol_month', name: 'vol_month', className: "dt-right"},
        { data: 'nil_qpu', name: 'nil_qpu', className: "dt-right"},
        { data: 'nm_mat', name: 'nm_mat'},
        { data: 'conditions', name: 'conditions'}
      ],
    });
  });
</script>
@endsection