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
        <li><i class="fa fa-files-o"></i> E-PROCUREMENT - REQUEST FOR QUOTATION</li>
        <li><a href="{{ route('prctrfqs.indexall') }}"><i class="fa fa-files-o"></i> Daftar RFQ</a></li>
        <li class="active">Detail RFQ  untuk SSR: {{ $prctrfq->no_ssr }}</li>
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
                    <td style="width: 14%;"><b>No. RFQ</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $prctrfq->no_rfq }}</td>
                    <td style="width: 10%;"><b>Tgl RFQ</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($prctrfq->tgl_rfq)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 14%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $prctrfq->no_rev }}</td>
                    <td style="width: 10%;"><b>Tgl Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ \Carbon\Carbon::parse($prctrfq->tgl_rev)->format('d/m/Y') }}</td>
                  </tr>
                  <tr>
                    <td style="width: 14%;"><b>No. SSR</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $prctrfq->no_ssr }}</td>
                    <td style="width: 10%;"><b>Condition</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctrfq->nm_proses }}</td>
                  </tr>
                  <tr>
                    <td style="width: 14%;"><b>Part No</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ $prctrfq->part_no }}</td>
                    <td style="width: 10%;"><b>Part Name</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctrfq->nm_part }}</td>
                  </tr>
                  <tr>
                    <td style="width: 14%;"><b>Vol./Month</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 15%;">{{ numberFormatter(0, 2)->format($prctrfq->vol_month) }}</td>
                    <td style="width: 10%;"><b>Model</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $prctrfq->ssr_nm_model }}</td>
                  </tr>
                  <tr>
                    <td style="width: 14%;"><b>Exchange Rate</b></td>
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
                  @if (!empty($prctrfq->tgl_send_supp))
                    <tr>
                      <td style="width: 14%;"><b>Send to Supplier</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctrfq->pic_send_supp }} - {{ $prctrfq->nama($prctrfq->pic_send_supp) }} - {{ \Carbon\Carbon::parse($prctrfq->tgl_send_supp)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($prctrfq->tgl_apr_supp))
                    <tr>
                      <td style="width: 14%;"><b>Approve by Supplier</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctrfq->pic_apr_supp }} - {{ $prctrfq->nama($prctrfq->pic_apr_supp) }} - {{ \Carbon\Carbon::parse($prctrfq->tgl_apr_supp)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($prctrfq->tgl_supp_submit))
                    <tr>
                      <td style="width: 14%;"><b>Submit by Supplier</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctrfq->pic_supp_submit }} - {{ $prctrfq->nama($prctrfq->pic_supp_submit) }} - {{ \Carbon\Carbon::parse($prctrfq->tgl_supp_submit)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($prctrfq->tgl_rjt_prc))
                    <tr>
                      <td style="width: 14%;"><b>Reject by PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctrfq->pic_rjt_prc }} - {{ $prctrfq->nama($prctrfq->pic_rjt_prc) }} - {{ \Carbon\Carbon::parse($prctrfq->tgl_rjt_prc)->format('d/m/Y H:i') }} - {{ $prctrfq->ket_rjt_prc }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($prctrfq->tgl_pilih))
                    <tr>
                      <td style="width: 14%;"><b>Selected By PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctrfq->pic_pilih }} - {{ $prctrfq->nama($prctrfq->pic_pilih) }} - {{ \Carbon\Carbon::parse($prctrfq->tgl_pilih)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($prctrfq->tgl_close))
                    <tr>
                      <td style="width: 14%;"><b>Closed By PRC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $prctrfq->pic_close }} - {{ $prctrfq->nama($prctrfq->pic_close) }} - {{ \Carbon\Carbon::parse($prctrfq->tgl_close)->format('d/m/Y H:i') }}
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
      @if ($prctrfq->nm_proses === "FORGING")
        @include('eproc.rfq._show-forging')
      @elseif($prctrfq->nm_proses === "TUBE")
        @include('eproc.rfq._show-tube')
      @elseif($prctrfq->nm_proses === "ASSY PART") 
        @include('eproc.rfq._show-assypart')
      @elseif($prctrfq->nm_proses === "MACHINING") 
        @include('eproc.rfq._show-machining')
      @elseif($prctrfq->nm_proses === "HEAT TREATMENT") 
        @include('eproc.rfq._show-ht')
      @elseif($prctrfq->nm_proses === "STAMPING")
        @include('eproc.rfq._show-stamping')
      @elseif($prctrfq->nm_proses === "PAINTING")
        @include('eproc.rfq._show-painting')
      @elseif($prctrfq->nm_proses === "CASTING")
        @include('eproc.rfq._show-casting')
      @endif
      <div class="box-footer">
        @if ($prctrfq->kd_bpid == Auth::user()->kd_supp && empty($prctrfq->tgl_supp_submit))
          @if (empty($prctrfq->tgl_apr_supp))
            @if (Auth::user()->can('prc-rfq-create'))
              <button id='btnapprove' type='button' class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Approve RFQ {{ $prctrfq->no_rfq }}' onclick='approveRfq("{{ $prctrfq->no_rfq }}", "SP")'>
                <span class='glyphicon glyphicon-check'></span> Approve RFQ
              </button>
              &nbsp;&nbsp;
            @endif
          @else
            @if (Auth::user()->can('prc-rfq-create'))
              <a class="btn btn-success" href="{{ route('prctrfqs.edit', base64_encode($prctrfq->no_rfq)) }}" data-toggle="tooltip" data-placement="top" title="Ubah Data">Ubah Data</a>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('prctrfqs.indexall') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard RFQ">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection