@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        CR Activities Progress [Budget]
        <small>Detail CR Activities Progress [Budget]</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Budget - TRANSAKSI</li>
        <li><a href="{{ route('bgttcrsubmits.indexbudget') }}"><i class="fa fa-files-o"></i> CR Activities Progress [Budget]</a></li>
        <li class="active">Detail</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">CR Activities Progress [Budget]</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 12%;"><b>ID Register</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">
                      @if (Auth::user()->can('budget-cr-activities-approve-budget'))
                        <a target="_blank" href="{{ route('bgttcrregiss.showbudget', base64_encode($bgttcrsubmit->id_regis)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail Register">
                          {{ $bgttcrsubmit->id_regis }}
                        </a>
                      @else
                        {{ $bgttcrsubmit->id_regis }}
                      @endif
                    </td>
                    <td style="width: 12%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($bgttcrsubmit->historys()->get()->count() > 0)
                        {{ $bgttcrsubmit->no_rev_submit }}
                        @foreach ($bgttcrsubmit->historys()->get() as $history)
                          @if (Auth::user()->can(['budget-cr-activities-*']))
                            {{ "&nbsp;-&nbsp;&nbsp;" }}
                            <a target="_blank" href="{{ route('bgttcrsubmits.showrevisi', base64_encode($history->id)) }}" data-toggle="tooltip" data-placement="top" title="Show History No. Revisi {{ $history->no_rev_submit }}">
                              {{ $history->no_rev_submit }}
                            </a>
                          @else
                            {{ "&nbsp;-&nbsp;&nbsp;".$history->no_rev_submit }}
                          @endif
                        @endforeach
                      @else
                        {{ $bgttcrsubmit->no_rev_submit }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Tahun</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $bgttcrsubmit->thn }}</td>
                    <td style="width: 12%;"><b>Bulan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ strtoupper(namaBulan((int) $bgttcrsubmit->bln)) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Activity</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $bgttcrsubmit->nm_aktivitas }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Classification</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $bgttcrsubmit->nm_klasifikasi }}</td>
                    <td style="width: 12%;"><b>CR Categories</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrsubmit->nm_kategori }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Divisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ $bgttcrsubmit->kd_div }} - {{ $bgttcrsubmit->namaDivisi($bgttcrsubmit->kd_div) }}</td>
                    <td style="width: 12%;"><b>Departemen</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $bgttcrsubmit->kd_dep }} - {{ $bgttcrsubmit->namaDepartemen($bgttcrsubmit->kd_dep) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>MP Plan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ numberFormatter(0, 0)->format($bgttcrsubmit->jml_plan) }}</td>
                    <td style="width: 12%;"><b>Amount Plan</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ numberFormatter(0, 2)->format($bgttcrsubmit->amt_plan) }}</td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>MP Actual</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 25%;">{{ numberFormatter(0, 0)->format($bgttcrsubmit->jml) }}</td>
                    <td style="width: 12%;"><b>Amount Actual</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      {{ numberFormatter(0, 2)->format($bgttcrsubmit->amt) }}
                      @if($bgttcrsubmit->amt_plan > 0)
                        (<strong>{{ numberFormatter(0, 2)->format(($bgttcrsubmit->amt / $bgttcrsubmit->amt_plan) * 100)."%" }}</strong>)
                      @else 
                        (<strong>{{ numberFormatter(0, 2)->format(0)."%" }}</strong>)
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Creaby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->creaby }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->creaby) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->dtcrea)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @if (!empty($bgttcrsubmit->dtmodi))
                  <tr>
                    <td style="width: 12%;"><b>Modiby</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->modiby }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->modiby) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->dtmodi)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrsubmit->submit_dt))
                  <tr>
                    <td style="width: 12%;"><b>Submit</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->submit_by }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->submit_by) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->submit_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrsubmit->apr_dep_dt))
                  <tr>
                    <td style="width: 12%;"><b>Approve Dept.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->apr_dep_by }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->apr_dep_by) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->apr_dep_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrsubmit->rjt_dep_dt))
                  <tr>
                    <td style="width: 12%;"><b>Reject Dept.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->rjt_dep_by }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->rjt_dep_by) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->rjt_dep_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Ket. Reject</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->rjt_dep_ket }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrsubmit->apr_div_dt))
                  <tr>
                    <td style="width: 12%;"><b>Approve Div.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->apr_div_by }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->apr_div_by) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->apr_div_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrsubmit->rjt_div_dt))
                  <tr>
                    <td style="width: 12%;"><b>Reject Div.</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->rjt_div_by }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->rjt_div_by) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->rjt_div_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Ket. Reject</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->rjt_div_ket }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrsubmit->apr_bgt_dt))
                  <tr>
                    <td style="width: 12%;"><b>Approve Budget</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->apr_bgt_by }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->apr_bgt_by) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->apr_bgt_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  @endif
                  @if (!empty($bgttcrsubmit->rjt_bgt_dt))
                  <tr>
                    <td style="width: 12%;"><b>Reject Budget</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->rjt_bgt_by }} - {{ $bgttcrsubmit->namaByNpk($bgttcrsubmit->rjt_bgt_by) }} - {{ \Carbon\Carbon::parse($bgttcrsubmit->rjt_bgt_dt)->format('d/m/Y H:i') }}
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 12%;"><b>Ket. Reject</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->rjt_bgt_ket }}
                    </td>
                  </tr>
                  @endif
                  <tr>
                    <td style="width: 12%;"><b>Status</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      {{ $bgttcrsubmit->status }}
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

      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $bgttcrsubmit->id_regis }}">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th rowspan="2" style="width: 5%;">No</th>
                    <th rowspan="2">Bulan</th>
                    <th colspan="2" style="width: 27%;text-align: center">Plan</th>
                    <th colspan="2" style="width: 27%;text-align: center">Actual</th>
                    <th rowspan="2" style="width: 5%;">%</th>
                    <th rowspan="2" style="width: 15%;">Status</th>
                  </tr>
                  <tr>
                    <th style="width: 12%;">Man Power</th>
                    <th style="width: 15%;">Amount</th>
                    <th style="width: 12%;">Man Power</th>
                    <th style="width: 15%;">Amount</th>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
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

      <div class="box-footer">
        @if ($bgttcrsubmit->status === "APPROVE DIV")
          @if (Auth::user()->can('budget-cr-activities-approve-budget'))
            <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve Activities Progress - Budget' onclick='approve()'>
              <span class='glyphicon glyphicon-check'></span> Approve Budget
            </button>
            &nbsp;&nbsp;
            <button id='btnreject' type='button' class='btn btn-danger' data-toggle='tooltip' data-placement='top' title='Reject Activities Progress - Budget' onclick='reject()'>
              <span class='glyphicon glyphicon-remove'></span> Reject Budget
            </button>
            &nbsp;&nbsp;
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('bgttcrsubmits.indexbudget') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Daftar CR Activities Progress">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function approve()
  {
    var msg = 'Anda yakin Approve Activity Progress tsb?';
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
      var url = "{{ route('bgttcrsubmits.approvebudget')}}";
      $("#loading").show();
      $.ajax({
        type     : 'POST',
        url      : url,
        dataType : 'json',
        data     : {
          _method        : 'POST',
          // menambah csrf token dari Laravel
          _token         : token,
          ids            : "{{ $bgttcrsubmit->id }}",
          status_approve : window.btoa("BUDGET")
        },
        success:function(data){
          $("#loading").hide();
          if(data.status === 'OK'){
            swal("Approved", data.message, "success");
            var urlRedirect = "{{ route('bgttcrsubmits.showbudget', 'param') }}";
            urlRedirect = urlRedirect.replace('param', window.btoa("{{ $bgttcrsubmit->id }}"));
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

  function reject()
  {
    var msg = 'Anda yakin REJECT Activity Progress tsb?';
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
        var url = "{{ route('bgttcrsubmits.rejectbudget')}}";
        $("#loading").show();
        $.ajax({
          type     : 'POST',
          url      : url,
          dataType : 'json',
          data     : {
            _method           : 'POST',
            // menambah csrf token dari Laravel
            _token            : token,
            ids               : "{{ $bgttcrsubmit->id }}",
            status_reject     : window.btoa("BUDGET"), 
            keterangan_reject : result
          },
          success:function(data){
            $("#loading").hide();
            if(data.status === 'OK'){
              swal("Rejected", data.message, "success");
              var urlRedirect = "{{ route('bgttcrsubmits.showbudget', 'param') }}";
              urlRedirect = urlRedirect.replace('param', window.btoa("{{ $bgttcrsubmit->id }}"));
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
    var id_regis = $('#field').data("field-id");
    var url = '{{ route('bgttcrsubmits.detail', 'param') }}';
    url = url.replace('param', window.btoa(id_regis));
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
      "order": [],
      processing: true, 
      // serverSide: true,
      // searching: false, 
      paging: false, 
      ajax: url,
      columns: [
        {data: null, name: null},
        {data: 'bulan', name: 'bulan'},
        {data: 'jml_mp', name: 'jml_mp', className: "dt-right"},
        {data: 'amount', name: 'amount', className: "dt-right"},
        {data: 'jml_mp_act', name: 'jml_mp_act', className: "dt-right"},
        {data: 'amount_act', name: 'amount_act', className: "dt-right"},
        {data: 'persen', name: 'persen', className: "dt-right"},
        {data: 'status', name: 'status', orderable: false, searchable: false}
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

        var column = 2;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 3;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 4;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );

        var column = 5;
        total = api.column(column).data().reduce( function (a, b) {
          return intVal(a) + intVal(b);
        },0);
        total = total.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
        $(api.column(column).footer() ).html(
          // 'Total OK: '+ pageTotal + ' ('+ total +')'
          '<p align="right">' + total + '</p>'
        );
      }
    });
  });
</script>
@endsection