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
                  <center><img src="{{ $smartmtc->fotokaryawan($npk) }}" class="img-rounded img-responsive" alt="File Not Found" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;"></center>
                </td>
                <td colspan="2" style="width: 80%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_SAFETY_ACHIEVEMENT.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_SAFETY_ACHIEVEMENT.png") }}')"></center>
                </td>
                <td rowspan="7" style="width: 10%;text-align: center">
                  <center>
                    <a href="{{ route('smartmtcs.kpi', [$tahun, "10137"]) }}">
                      <img src="{{ $smartmtc->fotokaryawan("10137") }}" class="img-rounded img-responsive" alt="File Not Found" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;">
                    </a>
                    <br>
                    <a href="{{ route('smartmtcs.kpi', [$tahun, "15343"]) }}">
                      <img src="{{ $smartmtc->fotokaryawan("15343") }}" class="img-rounded img-responsive" alt="File Not Found" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;">
                    </a>
                  </center>
                </td>
              </tr>
              <tr>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_MA_RA_ASSY.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 150%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_MA_RA_ASSY.png") }}')"></center>
                </td>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_MA_RA_PART.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_MA_RA_PART.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_MA_PS_ASSY.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_MA_PS_ASSY.png") }}')"></center>
                </td>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_MA_PS_PART.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_MA_PS_PART.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_PMA_RA_ASSY.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_PMA_RA_ASSY.png") }}')"></center>
                </td>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_PMA_RA_PART.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_PMA_RA_PART.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_PMA_PS_ASSY.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_PMA_PS_ASSY.png") }}')"></center>
                </td>
                <td style="width: 40%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_PMA_PS_PART.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_PMA_PS_PART.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 80%;text-align: center">
                  <center><img src="{{ $smartmtc->fotokpi($npk."_ABSENSI.png") }}" class="img-rounded img-responsive" alt="File Not Found" style="width: 100%;height: 100%;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $smartmtc->fotokpi($npk."_ABSENSI.png") }}')"></center>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="width: 80%;text-align: center">
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
  <footer style="background-color:white; min-height:50px;" class="navbar-fixed-bottom">
    <center>
      <a href="{{ route('smartmtcs.dashboardmtc2') }}" class="btn bg-navy">Home</a>
</center>
  </footer>
@endsection

@section('scripts')
<script type="text/javascript">
var urlParams = new URLSearchParams(window.location.search);
// let smartmtc = urlParams.has('type'); 
console.log(urlParams.has('type'))
if(urlParams.has('type')){
  var x = document.getElementById("btn-close");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}
  function showPict(title, lok_file) {
    $('#div-modal-dialog').attr('style', "width:80%");
    $("#imgModal-boxtitle").html(title);
    $('#imgModal-lok_pict').attr('src', lok_file);
  }
</script>
@endsection