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
        <li><i class="fa fa-files-o"></i> E-PPC - Transaksi</li>
        <li><a href="{{ route('ppctdprs.all') }}"><i class="fa fa-files-o"></i> Daftar DEPR</a></li>
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
              <h3 class="box-title">DPR</h3>
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
                  @if (!empty($ppctdpr->dh_dtaprov))
                    <tr>
                      <td style="width: 15%;"><b>Submit to Portal</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        {{ $ppctdpr->dh_aprov }} - {{ $ppctdpr->nama($ppctdpr->dh_aprov) }} - {{ \Carbon\Carbon::parse($ppctdpr->dh_dtaprov)->format('d/m/Y H:i') }}
                      </td>
                    </tr>
                  @endif
                  @if (!empty($ppctdpr->ppctDprPicas()))
                    <tr>
                      <td style="width: 13%;"><b>No. PICA</b></td>
                      <td style="width: 1%;"><b>:</b></td>
                      <td colspan="4">
                        <a href="{{ route('ppctdprpicas.show', base64_encode($ppctdpr->ppctDprPicas()->id)) }}" data-toggle="tooltip" data-placement="top" title="Show Detail PICA DEPR {{ $ppctdpr->ppctDprPicas()->no_dpr }}">{{ $ppctdpr->ppctDprPicas()->no_dpr }}</a>
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
      @if ($ppctdpr->kd_bpid == Auth::user()->kd_supp && !empty($ppctdpr->dh_aprov))
        <div class="box-footer">
          @if (!empty($ppctdpr->ppctDprPicas()))
            @if (Auth::user()->can(['ppc-picadpr-*']))
              <a class="btn btn-primary bg-black" href="{{ route("ppctdprpicas.show", base64_encode($ppctdpr->ppctDprPicas()->id)) }}" data-toggle="tooltip" data-placement="top" title="Show PICA DEPR {{ $ppctdpr->ppctDprPicas()->no_dpr }}"><span class='glyphicon glyphicon-transfer'></span> Show PICA DEPR</a>
              &nbsp;&nbsp;
            @endif
          @else
            @if (Auth::user()->can('ppc-picadpr-create'))
              <button id='btncreate' type='button' class='btn bg-green' data-toggle='tooltip' data-placement='top' title='Create PICA DEPR {{ $ppctdpr->no_dpr }}' onclick='createPica("{{ $ppctdpr->no_dpr }}")'>
                <span class='glyphicon glyphicon-transfer'></span> Create PICA DEPR
              </button>
              &nbsp;&nbsp;
            @endif
          @endif
          <a class="btn btn-primary" href="{{ route('ppctdprs.all') }}" data-toggle="tooltip" data-placement="top" title="Kembali ke Dashboard DEPR">Cancel</a>
        </div>
      @endif
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

  function createPica(no_dpr)
  {
    var msg = 'Anda yakin membuat PICA DEPR untuk data ini?';
    var txt = 'No. DEPR: ' + no_dpr;
    //additional input validations can be done hear
    swal({
      title: msg,
      text: txt,
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-thumbs-up"></i> Yes, create it!',
      cancelButtonText: '<i class="fa fa-thumbs-down"></i> No, cancel!',
      allowOutsideClick: true,
      allowEscapeKey: true,
      allowEnterKey: true,
      reverseButtons: false,
      focusCancel: true,
    }).then(function () {
      var urlRedirect = "{{ route('ppctdprpicas.edit', 'param') }}";
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
  }
</script>
@endsection