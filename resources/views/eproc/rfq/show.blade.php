@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        RFQ
        <small>Detail Request For Quotation</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - RFQ</li>
        <li><a href="{{ route('prctrfqs.index') }}"><i class="fa fa-files-o"></i> Daftar RFQ</a></li>
        <li class="active">Detail RFQ untuk SSR: {{ $prctrfq->no_ssr }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">RFQ</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 10%;"><b>No. SSR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $prctrfq->no_ssr }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Part No</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $prctrfq->part_no }}</td>
                    <td style="width: 10%;"><b>Part Name</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctrfq->nm_part }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Vol./Month</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ numberFormatter(0, 2)->format($prctrfq->vol_month) }}</td>
                    <td style="width: 10%;"><b>Condition</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctrfq->nm_proses }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Model</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4" style="white-space:pre;">{{ $prctrfq->ssr_nm_model }}</td>
                  </tr>
                  <tr>
                    <td style="width: 10%;"><b>Exchange Rate</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">
                      <table cellspacing="0" width="100%">
                        <tr>
                          <th style="width: 5%;text-align: center;">1 USD</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_usd) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 THB</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_thb) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 KRW</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_krw) }}</td>
                          <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;IDR</td>
                        </tr>
                        <tr>
                          <th style="width: 5%;text-align: center;">1 JPY</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_jpy) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 CNY</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_cny) }}</td>
                          <td style="width: 5%;text-align: center;">IDR</td>
                          <th style="width: 10%;text-align: right;">1 EUR</th>
                          <td style="width: 5%;text-align: center;">=</td>
                          <td style="width: 10%;text-align: right;">{{ numberFormatter(0, 5)->format($prctrfq->ssr_er_eur) }}</td>
                          <td style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;IDR</td>
                        </tr>
                      </table>
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
              <h3 class="box-title">Detail RFQ untuk SSR: {{ $prctrfq->no_ssr }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $prctrfq->no_ssr }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                    <tr>
                      <th style="width: 1%;">No</th>
                      <th style="width: 10%;">No. RFQ</th>
                      <th style="width: 5%;">Rev</th>
                      <th>BPID</th>
                      <th style="width: 10%;">Tgl RFQ</th>
                      <th style="width: 12%;">Tgl Revisi</th>
                      <th style="width: 10%;">Harga</th>
                      <th>Creaby</th>
                      <th>Modiby</th>
                      <th>Send to Supplier</th>
                      <th>Approve by Supplier</th>
                      <th>Submit by Supplier</th>
                      <th>Approve by PRC</th>
                      <th>Reject by PRC</th>
                      <th>Selected by PRC</th>
                      <th>Closed by PRC</th>
                      <th>Status</th>
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
        @if (Auth::user()->can(['prc-rfq-create','prc-rfq-delete']))
          <a class="btn btn-primary" href="{{ route('prctrfqs.modif', [base64_encode($prctrfq->no_ssr), base64_encode($prctrfq->part_no), base64_encode($prctrfq->nm_proses)]) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
          &nbsp;&nbsp;
        @endif
        <a class="btn btn-primary" href="{{ route('prctrfqs.index') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard RFQ">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  $(document).ready(function(){
    var no_ssr = $('#field').data("field-id");
    var part_no = "{{ $prctrfq->part_no }}";
    var nm_proses = "{{ $prctrfq->nm_proses }}";
    var url = '{{ route('prctrfqs.detail', ['param','param2','param3']) }}';    
    url = url.replace('param3', window.btoa(nm_proses));
    url = url.replace('param2', window.btoa(part_no));
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
      "order": [[1, 'desc'],[3, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        {data: null, name: null, className: "dt-center"},
        {data: 'no_rfq', name: 'no_rfq', className: "dt-center"},
        {data: 'no_rev', name: 'no_rev', className: "dt-center"},
        {data: 'kd_bpid', name: 'kd_bpid'},
        {data: 'tgl_rfq', name: 'tgl_rfq', className: "dt-center"},
        {data: 'tgl_rev', name: 'tgl_rev', className: "dt-center"},
        {data: 'nil_total', name: 'nil_total', className: "dt-right"},
        {data: 'creaby', name: 'creaby', orderable: false, searchable: false, className: "none"},
        {data: 'modiby', name: 'modiby', orderable: false, searchable: false, className: "none"},
        {data: 'pic_send_supp', name: 'pic_send_supp', orderable: false, searchable: false, className: "none"},
        {data: 'pic_apr_supp', name: 'pic_apr_supp', orderable: false, searchable: false, className: "none"},
        {data: 'pic_supp_submit', name: 'pic_supp_submit', orderable: false, searchable: false, className: "none"},
        {data: 'pic_apr_prc', name: 'pic_apr_prc', className: "none", orderable: false, searchable: false},
        {data: 'pic_rjt_prc', name: 'pic_rjt_prc', className: "none", orderable: false, searchable: false},
        {data: 'pic_pilih', name: 'pic_pilih', orderable: false, searchable: false, className: "none"},
        {data: 'pic_close', name: 'pic_close', orderable: false, searchable: false, className: "none"},
        {data: 'status', name: 'status', orderable: false, searchable: false, className: "none"}
      ]
    });
  });
</script>
@endsection