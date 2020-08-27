@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        History PO
        <small>Detail History PO</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> PROCUREMENT - TRANSAKSI - PO</li>
        <li><a href="{{ route('baanpo1s.index') }}"><i class="fa fa-files-o"></i> Daftar PO</a></li>
        <li class="active">Detail History PO {{ $baanpo1->no_po }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Master PO: {{ $baanpo1->no_po }} Revisi: {{ $baanpo1->no_revisi }}</h3>
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
                    <td>{{ $baanpo1->no_revisi }}</td>
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
                    @if (strlen(Auth::user()->username) == 5)
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
                    @else 
                      <tr>
                        <td style="width: 13%;"><b>Jenis PO</b></td>
                        <td style="width: 1%;"><b>:</b></td>
                        <td colspan="4">{{ $baanpo1->jns_po }}</td>
                      </tr>
                    @endif
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
              <h3 class="box-title">Detail History PO: {{ $baanpo1->no_po }} Revisi: {{ $baanpo1->no_revisi }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="field" data-field-id="{{ $baanpo1->no_po }}" data-field-rev="{{ $baanpo1->no_revisi }}">
              <table id="tblDetail" class="table table-bordered table-hover" cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th style="width: 1%;">No</th>
                    <th style="width: 5%;">PONO</th>
                    <th style="width: 10%;">No PP</th>
                    <th style="width: 15%;">Item No</th>
                    <th>Description</th>
                    <th style="width: 10%;">Qty PO</th>
                    <th style="width: 5%;">Satuan</th>
                    <th style="width: 12%;">Harga Unit</th>
                    <th style="width: 12%;">Jumlah</th>
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
        <a class="btn btn-primary" href="#" onclick="window.open('', '_self', ''); window.close();" data-toggle="tooltip" data-placement="top" title="Close Tab">Close</a>
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">
  
  $(document).ready(function(){
    var no_po = $('#field').data("field-id");
    var no_revisi = $('#field').data("field-rev");
    var url = '{{ route('baanpo1s.detailrevisi', ['param','param2']) }}';    
    url = url.replace('param2', window.btoa(no_revisi));
    url = url.replace('param', window.btoa(no_po));
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
      "order": [[1, 'asc'],[2, 'asc']],
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      serverSide: true,
      ajax: url,
      columns: [
        { data: null, name: null, className: "dt-center"},
        { data: 'pono_po', name: 'pono_po', className: "dt-center"},
        { data: 'no_pp', name: 'no_pp'},
        { data: 'item_no', name: 'item_no'},
        { data: 'item_name', name: 'item_name'},
        { data: 'qty_po', name: 'qty_po', className: "dt-right"},
        { data: 'unit', name: 'unit', className: "dt-center"},
        { data: 'hrg_unit', name: 'hrg_unit', className: "dt-right"},
        { data: 'jumlah', name: 'jumlah', className: "dt-right"}
      ],
    });
  });
</script>
@endsection