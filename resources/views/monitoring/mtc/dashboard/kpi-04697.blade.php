@extends('monitoring.mtc.layouts.app3')

@section('content')
  <div class="container2">
    <div class="row" id="box-body" name="box-body">
      <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <center>
              <h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;">
                <strong>
                  KPI MAINTENANCE IGP JAKARTA {{ $tahun }}
                </strong>
              </h3>
            </center>
            <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body form-horizontal">
            <table id="tblMaster" class="table table-bordered" border="2" width="100%">
              <tr>
                <td rowspan="7" style="width: 10%;text-align: center">
                  <center>
                    <a class="btn btn-primary" href="{{ route('smartmtcs.kpi', [$tahun, "07217"]) }}" data-toggle="tooltip" data-placement="top" title="KPI Dept. Head" style="margin-bottom: 3px;width: 100%">KPI Dept. Head</a>
                    <br>
                    <a class="btn btn-primary" href="{{ route('smartmtcs.kpi', [$tahun, "10137"]) }}" data-toggle="tooltip" data-placement="top" title="KPI Sect. Head 2" style="margin-bottom: 3px;width: 100%">KPI Sect. Head 2</a>
                    <br>
                    <img src="{{ $smartmtc->fotokaryawan($npk) }}" class="img-rounded img-responsive" alt="File Not Found" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;">
                  </center>
                </td>
                <td colspan="2" style="width: 90%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_SAFETY_ACHIEVEMENT.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_SAFETY_ACHIEVEMENT.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td style="width: 45%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_MA_AS-B.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_MA_AS-B.png") }}')"></center>
                </td>
                <td style="width: 45%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_MA_HOUSING-E.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_MA_HOUSING-E.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td style="width: 45%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_MA_HOUSING-D.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_MA_HOUSING-D.png") }}')"></center>
                </td>
                <td style="width: 45%;text-align: center">
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td style="width: 45%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_PMA_AS-B.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_PMA_AS-B.png") }}')"></center>
                </td>
                <td style="width: 45%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_PMA_HOUSING-E.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_PMA_HOUSING-E.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td style="width: 45%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_PMA_HOUSING-D.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_PMA_HOUSING-D.png") }}')"></center>
                </td>
                <td style="width: 45%;text-align: center">
                  &nbsp;
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 90%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_ABSENSI.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_ABSENSI.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 90%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_IMPROVE.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_IMPROVE.png") }}')"></center>
                </td>
              </tr>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  @include('monitoring.mtc.dashboard.imgModal')
@endsection

@section('scripts')
<script type="text/javascript">
  function showPict(title, lok_file) {
    $('#div-modal-dialog').attr('style', "width:80%");
    $("#imgModal-boxtitle").html(title);
    $('#imgModal-lok_pict').attr('src', lok_file);
  }
</script>
@endsection