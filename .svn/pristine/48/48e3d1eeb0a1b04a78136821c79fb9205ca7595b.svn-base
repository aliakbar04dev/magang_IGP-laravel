@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Approval PO Section Head
        <small>Detail Approval PO SH</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li><a href="{{ route('baanpo1s.indexsh') }}"><i class="fa fa-files-o"></i> Approval PO SH</a></li>
        <li class="active">Detail PO {{ $baanpo1->no_po }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Master PO {{ $baanpo1->no_po }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-striped" cellspacing="0" width="100%">
                <tbody>
                  <tr>
                    <td style="width: 13%;"><b>No. PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $baanpo1->no_po }}</td>
                    <td style="width: 9%;"><b>No. Revisi</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>
                      @if ($baanPo1Rejects->get()->count() > 0)
                        {{ $baanpo1->no_revisi }}
                        @foreach ($baanPo1Rejects->get() as $baanPo1Reject)
                          @if (Auth::user()->can('prc-po-apr-*'))
                            {{ "&nbsp;-&nbsp;&nbsp;" }}<a target="_blank" href="{{ route('baanpo1s.showrevisi', [base64_encode($baanPo1Reject->no_po), base64_encode($baanPo1Reject->no_revisi)]) }}" data-toggle="tooltip" data-placement="top" title="Show History PO No. Revisi {{ $baanPo1Reject->no_revisi }}">{{ $baanPo1Reject->no_revisi }}</a>
                          @else
                            {{ "&nbsp;-&nbsp;&nbsp;".$baanPo1Reject->no_revisi }}
                          @endif
                        @endforeach
                      @else
                        {{ $baanpo1->no_revisi }}
                      @endif
                    </td>
                  </tr>
                  <tr>
                    <td style="width: 13%;"><b>Tgl PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ \Carbon\Carbon::parse($baanpo1->tgl_po)->format('d/m/Y') }}</td>
                    <td style="width: 9%;"><b>Supplier</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $baanpo1->kd_supp }} - {{ $baanpo1->nm_supp }}</td>
                  </tr>
                  <tr>
                    <td style="width: 13%;"><b>Mata Uang</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td style="width: 20%;">{{ $baanpo1->kd_curr }}</td>
                    <td style="width: 9%;"><b>Ref A</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td>{{ $baanpo1->refa }}</td>
                  </tr>
                  <tr>
                    <td style="width: 13%;"><b>Pembuat PO</b></td>
                    <td style="width: 1%;"><b>:</b></td>
                    <td colspan="4">{{ $baanpo1->pembuat_po }}</td>
                  </tr>
                  @if (!empty($baanpo1->ket_revisi))
                    <tr>
                      <td style="width: 13%;"><b>Ket. Revisi</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->ket_revisi }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->apr_pic_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Jenis PO</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td style="width: 20%;">{{ $baanpo1->jns_po }}</td>
                      <td style="width: 9%;"><b>St. Tampil</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td>
                        @if ($baanpo1->st_tampil === "T")
                          TAMPIL DI SUPPLIER
                        @else
                          TIDAK TAMPIL DI SUPPLIER
                        @endif
                      </td>
                    </tr>
                    <tr>
                      <td style="width: 13%;"><b>Approval PIC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->apr_pic_npk }} - {{ Auth::user()->namaByNpk($baanpo1->apr_pic_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->apr_pic_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->rjt_pic_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Reject PIC</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->rjt_pic_npk }} - {{ Auth::user()->namaByNpk($baanpo1->rjt_pic_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->rjt_pic_tgl)->format('d/m/Y H:i') }} - {{ $baanpo1->rjt_pic_ket }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->apr_sh_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Approval Section</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->apr_sh_npk }} - {{ Auth::user()->namaByNpk($baanpo1->apr_sh_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->apr_sh_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->rjt_sh_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Reject Section</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->rjt_sh_npk }} - {{ Auth::user()->namaByNpk($baanpo1->rjt_sh_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->rjt_sh_tgl)->format('d/m/Y H:i') }} - {{ $baanpo1->rjt_sh_ket }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->apr_dep_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Approval Dep Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->apr_dep_npk }} - {{ Auth::user()->namaByNpk($baanpo1->apr_dep_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->apr_dep_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->rjt_dep_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Reject Dep Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->rjt_dep_npk }} - {{ Auth::user()->namaByNpk($baanpo1->rjt_dep_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->rjt_dep_tgl)->format('d/m/Y H:i') }} - {{ $baanpo1->rjt_dep_ket }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->apr_div_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Approval Div Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->apr_div_npk }} - {{ Auth::user()->namaByNpk($baanpo1->apr_div_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->apr_div_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->rjt_div_tgl))
                    <tr>
                      <td style="width: 13%;"><b>Reject Div Head</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->rjt_div_npk }} - {{ Auth::user()->namaByNpk($baanpo1->rjt_div_npk) }} - {{ \Carbon\Carbon::parse($baanpo1->rjt_div_tgl)->format('d/m/Y H:i') }} - {{ $baanpo1->rjt_div_ket }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->print_supp_tgl))
                    <tr>
                      <td style="width: 13%;"><b>PIC Print</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $baanpo1->print_supp_pic }} - {{ Auth::user()->namaByUsername($baanpo1->print_supp_pic) }} - {{ \Carbon\Carbon::parse($baanpo1->print_supp_tgl)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (strlen(Auth::user()->username) == 5 && !empty($baanpo1->lok_file1))
                    <tr>
                      <td style="width: 13%;"><b>PP Instruction</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        @if ($baanpo1->file1 !== "")
                          <div class="row" id="field_1">
                            <div class="col-md-12">
                              <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_1">File PP Instruction</h3>
                                  <div class="box-tools pull-right">
                                    <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('baanpo1s.downloadfile', $baanpo1->lok_file1) }}"><span class='glyphicon glyphicon-download-alt'></span></a>
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <iframe src="{{ $baanpo1->file1 }}" width="80%" height="300px"></iframe>
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->lok_file2))
                    <tr>
                      <td style="width: 13%;"><b>Quotation 1</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        @if ($baanpo1->file2 !== "")
                          <div class="row" id="field_2">
                            <div class="col-md-12">
                              <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_2">File Quotation 1</h3>
                                  <div class="box-tools pull-right">
                                    <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('baanpo1s.downloadfile', $baanpo1->lok_file2) }}"><span class='glyphicon glyphicon-download-alt'></span></a>
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <iframe src="{{ $baanpo1->file2 }}" width="80%" height="300px"></iframe>
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->lok_file3))
                    <tr>
                      <td style="width: 13%;"><b>Quotation 2</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        @if ($baanpo1->file3 !== "")
                          <div class="row" id="field_3">
                            <div class="col-md-12">
                              <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_3">File Quotation 2</h3>
                                  <div class="box-tools pull-right">
                                    <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('baanpo1s.downloadfile', $baanpo1->lok_file3) }}"><span class='glyphicon glyphicon-download-alt'></span></a>
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <iframe src="{{ $baanpo1->file3 }}" width="80%" height="300px"></iframe>
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->lok_file4))
                    <tr>
                      <td style="width: 13%;"><b>Quotation 3</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        @if ($baanpo1->file4 !== "")
                          <div class="row" id="field_4">
                            <div class="col-md-12">
                              <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_4">File Quotation 3</h3>
                                  <div class="box-tools pull-right">
                                    <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('baanpo1s.downloadfile', $baanpo1->lok_file4) }}"><span class='glyphicon glyphicon-download-alt'></span></a>
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <iframe src="{{ $baanpo1->file4 }}" width="80%" height="300px"></iframe>
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        @endif
                      </td>
                    </tr>
                  @endif
                  @if (!empty($baanpo1->lok_file5))
                    <tr>
                      <td style="width: 13%;"><b>Drawing</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        @if ($baanpo1->file5 !== "")
                          <div class="row" id="field_5">
                            <div class="col-md-12">
                              <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title" id="box_5">Drawing</h3>
                                  <div class="box-tools pull-right">
                                    <a target="_blank" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Download File" href="{{ route('baanpo1s.downloadfile', $baanpo1->lok_file5) }}"><span class='glyphicon glyphicon-download-alt'></span></a>
                                    <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                                      <i class="fa fa-minus"></i>
                                    </button>
                                  </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <iframe src="{{ $baanpo1->file5 }}" width="80%" height="300px"></iframe>
                                </div>
                                <!-- /.box-body -->
                              </div>
                              <!-- /.box -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        @endif
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
              <h3 class="box-title">Detail PO {{ $baanpo1->no_po }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $baanpo1->no_po }}">
              <table id="tblDetail" class="table table-bordered table-striped" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 1%;">PONO</th>
                    <th style="width: 5%;">No PP</th>
                    <th style="width: 15%;">Item No</th>
                    <th>Description</th>
                    <th style="width: 5%;">Qty PO</th>
                    <th style="width: 5%;">Sat</th>
                    <th style="width: 10%;">Harga Unit</th>
                    <th style="width: 10%;">Jumlah</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($baanpo2s->get() as $baanpo2)
                    <tr>
                      <td style="text-align: center;">{{ $loop->iteration }}</td>
                      <td style="text-align: center;">{{ $baanpo2->pono_po }}</td>
                      <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">{{ $baanpo2->no_pp }}</td>
                      <td style="white-space: nowrap;overflow: auto;text-overflow: clip;">{{ $baanpo2->item_no }}</td>
                      <td style="white-space: nowrap;max-width: 100px;overflow: auto;text-overflow: clip;">
                        @if($baanpo2->item_no === "TOOLING ENG")
                          @if($baanpo2->item_name2 != null)
                            {{ $baanpo2->item_name2 }}
                          @else 
                            {{ $baanpo2->item_name }}
                          @endif
                        @else 
                          {{ $baanpo2->item_name }}
                        @endif
                      </td>
                      <td style="text-align: right;">{{ numberFormatter(0, 5)->format($baanpo2->qty_po) }}</td>
                      <td style="text-align: center">{{ $baanpo2->unit }}</td>
                      <td style="text-align: right;">{{ numberFormatter(0, 5)->format($baanpo2->hrg_unit) }}</td>
                      <td style="text-align: right;">{{ numberFormatter(0, 5)->format($baanpo2->jumlah) }}</td>
                    </tr>
                  @endforeach
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
              <h3 class="box-title"><p id="info-detail2">History</p></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tblHistory" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 10%;">No. PO</th>
                    <th style="width: 10%;">Tgl PO</th>
                    <th style="width: 12%;">Tgl Kirim</th>
                    <th>Supplier</th>
                    <th style="width: 5%;">MU</th>
                    <th style="width: 12%;">Harga Unit</th>
                    <th style="width: 10%;">QTY PO</th>
                    <th style="width: 10%;">QTY LPB</th>
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
        @if(Auth::user()->can('prc-po-apr-download'))
          @if($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null)
            @if($baanpo1->apr_pic_tgl != null && $baanpo1->apr_sh_tgl != null && $baanpo1->apr_dep_tgl != null && $baanpo1->apr_div_tgl != null)
              <a target="_blank" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Download PO {{ $baanpo1->no_po }}" href="{{ route('baanpo1s.print', base64_encode($baanpo1->no_po)) }}"><span class='glyphicon glyphicon-print'></span> Download PO</a>
              &nbsp;&nbsp;
            @else
              <a target="_blank" class="btn btn-default" data-toggle="tooltip" data-placement="top" title="Download PO {{ $baanpo1->no_po }}" href="{{ route('baanpo1s.print', base64_encode($baanpo1->no_po)) }}"><span class='glyphicon glyphicon-print'></span> Download PO</a>
              &nbsp;&nbsp;
            @endif
          @endif
        @endif
        <a class="btn btn-primary" href="{{ route('baanpo1s.indexsh') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard Approval PO SH">Cancel</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  
  $(document).ready(function(){
    var tableDetail = $('#tblDetail').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 10,
      // 'responsive': true,
      //'searching': false,
      "scrollX": true,
      "scrollY": "275px",
      "scrollCollapse": true,
      "paging": false,
    });

    $('#tblDetail tbody').on( 'click', 'tr', function () {
      if ($(this).hasClass('selected') ) {
        $(this).removeClass('selected');
        document.getElementById("info-detail2").innerHTML = 'History Harga';
        initTable2(window.btoa('-'), window.btoa('{{ \Carbon\Carbon::parse($baanpo1->tgl_po)->format('d/m/Y') }}'));
      } else {
        tableDetail.$('tr.selected').removeClass('selected');
        $(this).addClass('selected');
        if(tableDetail.rows().count() > 0) {
          var tgl_po = '{{ \Carbon\Carbon::parse($baanpo1->tgl_po)->format('d/m/Y') }}';
          var index = tableDetail.row('.selected').index();
          var item_no = tableDetail.cell(index, 3).data();
          var item_name = tableDetail.cell(index, 4).data();
          var info = item_no + " - " + item_name;
          document.getElementById("info-detail2").innerHTML = 'History Harga (' + info + ')';
          var regex = /(<([^>]+)>)/ig;
          initTable2(window.btoa(item_no.replace(regex, "")), window.btoa(tgl_po));
        }
      }
    });

    var urlHistory = '{{ route('baanpo1s.history', ['param','param2']) }}';
    urlHistory = urlHistory.replace('param2', window.btoa("{{ \Carbon\Carbon::parse($baanpo1->tgl_po)->format('d/m/Y') }}"));
    urlHistory = urlHistory.replace('param', window.btoa("-"));
    var tableHistory = $('#tblHistory').DataTable({
      "columnDefs": [{
        "searchable": false,
        "orderable": false,
        "targets": 0,
        render: function (data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }],
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": 5,
      responsive: true,
      "order": [[2, 'desc'],[1, 'desc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: urlHistory,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'no_po', name: 'no_po', className: "dt-center"},
        { data: 'tgl_po', name: 'tgl_po', className: "dt-center"},
        { data: 'ddat', name: 'ddat', className: "dt-center"},
        { data: 'supplier', name: 'supplier'},
        { data: 'kd_curr', name: 'kd_curr', className: "dt-center"},
        { data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"}, 
        { data: 'qty_po', name: 'qty_po', className: "dt-right"}, 
        { data: 'qty_lpb', name: 'qty_lpb', className: "dt-right"}
      ],
    });

    function initTable2(item_no, tgl_po) {
      tableHistory.search('').columns().search('').draw();
      var url = '{{ route('baanpo1s.history', ['param', 'param2']) }}';
      url = url.replace('param2', tgl_po);
      url = url.replace('param', item_no);
      tableHistory.ajax.url(url).load();
    }

    if(tableDetail.rows().count() > 0) {
      $('#tblDetail tbody tr:eq(0)').click(); 
    }
  });

  setTimeout(function(){
    var tableDetail = $('#tblDetail').DataTable();
    if(tableDetail.rows().count() > 0) {
      $('#tblDetail tbody tr:eq(0)').click(); 
    }
  }, 1000);
</script>
@endsection