@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Register Permintaan Pembelian
        <small>Detail Register PP</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PP</li>
        <li><a href="{{ route('ppregs.index') }}"><i class="fa fa-files-o"></i> Register PP</a></li>
        <li class="active">Detail {{ $ppReg->no_reg }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Master Register PP</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>No. Register</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $ppReg->no_reg }}</td>
                    <td style="width: 15%;"><b>Tgl Register</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($ppReg->tgl_reg)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Pemakai</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $ppReg->pemakai }}</td>
                    <td style="width: 15%;"><b>Untuk</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ppReg->untuk }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $ppReg->kd_dept_pembuat }} - {{ $ppReg->nm_dept }}</td>
                    <td style="width: 15%;"><b>Alasan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ppReg->alasan }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Email Supplier</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $ppReg->email_supp }}</td>
                    <td style="width: 15%;"><b>Supplier</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ppReg->kd_supp }} - {{ $ppReg->namaSupp($ppReg->kd_supp) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>No. IA/EA / Rev</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $ppReg->no_ia_ea }} / {{ $ppReg->no_ia_ea_revisi }}</td>
                    <td style="width: 15%;"><b>No. Urut IA/EA</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ppReg->no_ia_ea_urut }} / {{ $ppReg->descIaEa($ppReg->no_ia_ea, $ppReg->no_ia_ea_revisi, $ppReg->no_ia_ea_urut) }}</td>
                  </tr>
                  @if (!empty($ppReg->npk_approve_div))
                    <tr>
                      <td style="width: 12%;"><b>Tgl App. Div. Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ppReg->tgl_approve_div))
                          {{ \Carbon\Carbon::parse($ppReg->tgl_approve_div)->format('d/m/Y H:i') }}
                        @endif
                      </td>
                      <td style="width: 15%;"><b>Approve Div. Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ppReg->npk_approve_div }} - {{ $ppReg->nama($ppReg->npk_approve_div) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ppReg->npk_approve_prc))
                    <tr>
                      <td style="width: 12%;"><b>Tgl App. PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">
                        @if (!empty($ppReg->tgl_approve_prc))
                          {{ \Carbon\Carbon::parse($ppReg->tgl_approve_prc)->format('d/m/Y H:i') }}
                        @endif
                      </td>
                      <td style="width: 15%;"><b>Approve Purchasing</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>{{ $ppReg->npk_approve_prc }} - {{ $ppReg->nama($ppReg->npk_approve_prc) }}</td>
                    </tr>
                  @endif
                  @if (!empty($ppReg->npk_reject))
                    <tr>
                      <td style="width: 12%;"><b>Reject By</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">{{ $ppReg->npk_reject }} - {{ $ppReg->nama($ppReg->npk_reject) }}</td>
                      <td style="width: 15%;"><b>Tgl Reject - Keterangan</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        @if (!empty($ppReg->tgl_reject))
                          {{ \Carbon\Carbon::parse($ppReg->tgl_reject)->format('d/m/Y H:i') }} - {{ $ppReg->keterangan }}
                        @else
                          {{ $ppReg->keterangan }}
                        @endif
                      </td>
                    </tr>
                  @endif
                  <tr>
                    <td style="width: 12%;"><b>Status Approve</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">
                      @if ($ppReg->status_approve === 'F')BELUM
                      @elseif ($ppReg->status_approve === 'D')DIV HEAD
                      @elseif ($ppReg->status_approve === 'P')PURCHASING
                      @elseif ($ppReg->status_approve === 'R')REJECT
                      @endif
                    </td>
                    <td style="width: 15%;"><b>No. PP</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $ppReg->no_pp }}</td>
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
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Register PP</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $ppReg->no_reg }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th>Kode Barang</th>
                    <th>Deskripsi</th>
                    <th>Nama Barang PRC</th>
                    <th>Qty PP</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Qty PP</th>
                  </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      @if (empty($ppReg->no_pp))
        @if (Auth::user()->can(['pp-reg-approve-*', 'pp-reg-delete']))
          <div class="box-footer">
            @if ($ppReg->status_approve === 'F')
              @if (Auth::user()->can('pp-reg-delete') && $ppReg->kd_dept_pembuat == Auth::user()->masKaryawan()->kode_dep)
                <button id="btn-delete" type="button" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Delete Register PP {{ $ppReg->no_reg }}">
                  <span class='glyphicon glyphicon-trash'></span> Delete Register PP
                </button>
                &nbsp;&nbsp;
              @endif
              @if (Auth::user()->can('pp-reg-approve-div') && substr($ppReg->kd_dept_pembuat, 0, 1) == substr(Auth::user()->masKaryawan()->kode_dep, 0, 1))
                <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Register PP {{ $ppReg->no_reg }}' onclick='approveRegPp("{{ $ppReg->no_reg }}", "D")'>
                  <span class='glyphicon glyphicon-check'></span> Approve Div Head
                </button>
                &nbsp;&nbsp;
                <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Register PP {{ $ppReg->no_reg }}' onclick='rejectRegPp("{{ $ppReg->no_reg }}")'>
                  <span class='glyphicon glyphicon-remove'></span> Reject Register PP
                </button>
              @endif
            @elseif ($ppReg->status_approve === 'D')
              @if (Auth::user()->can('pp-reg-approve-prc'))
                <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Register PP {{ $ppReg->no_reg }}' onclick='approveRegPp("{{ $ppReg->no_reg }}", "P")'>
                  <span class='glyphicon glyphicon-check'></span> Approve Purchasing
                </button>
                &nbsp;&nbsp;
                <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Register PP {{ $ppReg->no_reg }}' onclick='rejectRegPp("{{ $ppReg->no_reg }}")'>
                <span class='glyphicon glyphicon-remove'></span> Reject Register PP
                </button>
              @endif
            @endif
          </div>
        @endif
      @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function approveRegPp(no_reg, status)
  {
    var msg = 'Anda yakin APPROVE No. Register PP ' + no_reg;
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
      var urlRedirect = "{{ route('ppregs.approve', ['param', 'param2']) }}";
      urlRedirect = urlRedirect.replace('param', window.btoa(no_reg));
      urlRedirect = urlRedirect.replace('param2', window.btoa(status));
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
  }

  function rejectRegPp(no_reg)
  {
    var msg = 'Anda yakin REJECT No. Register PP ' + no_reg;
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
        var urlRedirect = "{{ route('ppregs.reject', ['param', 'param2']) }}";
        urlRedirect = urlRedirect.replace('param', window.btoa(no_reg));
        urlRedirect = urlRedirect.replace('param2', window.btoa(result));
        window.location.href = urlRedirect;
      })

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
    var no_reg = "{{ $ppReg->no_reg }}";
    var id = "{{ $ppReg->id }}";
    var msg = 'Anda yakin menghapus No. Register PP ' + no_reg;
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
      var urlRedirect = "{{ route('ppregs.destroy', 'param') }}";
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

  $(document).ready(function(){
    var no_reg = $('#field').data("field-id");
    var url = '{{ route('ppregs.detail', 'param') }}';
    url = url.replace('param', window.btoa(no_reg));
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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: null, name: null },
        { data: 'kd_brg', name: 'kd_brg' },
        { data: 'desc', name: 'desc' },
        { data: 'nm_brg', name: 'nm_brg' },
        { data: 'qty_pp', name: 'qty_pp', className: "dt-right"}
    ],
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function (i) {
            return typeof i === 'string' ?
                i.replace(/[\$,]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };

        var column = 4;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        // pageTotal = api.column(column, { page: 'current'} ).data().reduce( function (a, b) {
        //   return intVal(a) + intVal(b);
        // },0);
        // Update footer
        // pageTotal = pageTotal.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
            // 'Total OK: '+ pageTotal + ' ('+ total +')'
            total
        );
      }
    });
  });
</script>
@endsection