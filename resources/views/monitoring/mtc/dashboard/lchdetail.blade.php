@extends('monitoring.mtc.layouts.app3')
<style>
  #field_data { 
    height: 100%; 
    overflow-y: scroll;
    overflow-x: hidden;
  }
</style>
@section('content')
  <div class="container3">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <table width="100%">
              <tr>
                <th style='width: 10%;text-align: center'>&nbsp;</th>
                <th style='text-align: center'>
                  <h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 26px;">
                    <strong>DETAIL LCH <BR>Tanggal: {{ \Carbon\Carbon::createFromFormat('Ymd', $tgl)->format('d M Y') }}, Shift: {{ $shift }}, Unit: {{ $kd_unit }} - {{ $nm_unit }}</strong>
                  </h3>
                </th>
                <th style='width: 10%;text-align: right;'>
                  <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                    <span class="glyphicon glyphicon-remove"></span>
                  </button>
                </th>
              </tr>
            </table>
          </div>

          <div class="panel-body" id="field_data">
            <div class="form-group" id="form-group-foto" name="form-group-foto">
              <div class="col-sm-12">
                <div class="box box-primary collapsed-box">
                  <div class="box-header with-border">
                    <h3 class="box-title">
                      @if (isset($lok_pict))
                        Foto (Ada)
                      @else 
                        Foto (Tidak Ada)
                      @endif
                    </h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <center>
                      @if (isset($lok_pict))
                        <img src="{{ $lok_pict }}" class="img-rounded img-responsive" alt="File Not Found" id="lok_pict">
                      @else 
                        <img src="" class="img-rounded img-responsive" alt="File Not Found" id="lok_pict">
                      @endif
                    </center>
                    <p class="text-muted text-center"></p>
                  </div>
                  <!-- ./box-body -->
                </div>
                <!-- /.box -->
              </div>
            </div>
            <!-- /.form-group -->
            @if (isset($mtct_lch_forklif2s))
              <div class="box-body">
                <table id="tblMaster" class="table table-bordered table-striped" cellspacing="0" width="100%">
                  <caption>
                    <strong>
                      @if($mtct_lch_forklif1->st_cuci != null) 
                        @if($mtct_lch_forklif1->st_cuci === "T") 
                          &nbsp;&nbsp;&nbsp;Status Cuci: YA
                        @elseif($mtct_lch_forklif1->st_cuci === "F") 
                          &nbsp;&nbsp;&nbsp;Status Cuci: TIDAK
                        @else
                          &nbsp;&nbsp;&nbsp;Status Cuci: -
                        @endif
                      @else
                        &nbsp;&nbsp;&nbsp;Status Cuci: -
                      @endif
                      @if($mtct_lch_forklif1->st_unit != null) 
                        ,&nbsp;&nbsp;&nbsp;Status Unit: {{ $mtct_lch_forklif1->st_unit }}
                      @else
                        ,&nbsp;&nbsp;&nbsp;Status Unit: Normal
                      @endif
                    </strong>
                  </caption>
                  <thead>
                    <tr>
                      <th style="width: 20%;">Item Check</th>
                      <th style="width: 20%;">Ketentuan</th>
                      <th style="width: 15%;">Cara</th>
                      <th style="width: 10%;">Alat</th>
                      <th style="text-align: center;width: 5%;">Status</th>
                      <th>Uraian Masalah</th>
                      <th style="width: 5%;">Picture</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($mtct_lch_forklif2s->get() as $data)
                      <tr>
                        <td>
                          {{ $data->nm_is }}
                        </td>
                        <td>
                          {{ $data->ketentuan }}
                        </td>
                        <td>
                          {{ $data->metode }}
                        </td>
                        <td>
                          {{ $data->alat }}
                        </td>
                        <td style="text-align: center;">
                          @if($data->nm_is != null)
                            @if($data->st_cek === "T")
                              OK
                            @else 
                              NG
                            @endif
                          @endif
                        </td>
                        <td>
                          @if($data->nm_is != null)
                            {{ $data->uraian_masalah }}
                          @endif
                        </td>
                        <td style="text-align: center;">
                          @if($data->nm_is != null)
                            @if($data->pict_masalah != null)
                              <p><img src="{{ $mtct_lch_forklif1->pict($data->pict_masalah) }}" alt="File Not Found" class="img-rounded img-responsive" style="border: 1px solid #ddd;border-radius: 4px;padding: 5px;width: 100px;" data-toggle="modal" data-target="#imgModal" onclick="showPict('Picture', '{{ $mtct_lch_forklif1->pict($data->pict_masalah) }}')"></p>
                            @endif
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              @if ($mtct_lch_forklif2s->get()->count() > 0)
                <div class="box-footer">
                  <div class="form-group">
                    <div class="col-sm-4">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">
                            @if (!empty($mtct_lch_forklif1->pict_kiri))
                              Foto dari sisi kiri (Ada)
                            @else 
                              Foto dari sisi kiri (Tidak Ada)
                            @endif
                          </h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-12">
                              {!! Form::label('pict_kiri', 'Picture Kiri (jpeg,png,jpg)') !!}
                              @if (!empty($mtct_lch_forklif1->pict_kiri))
                                <p>
                                  <img src="{{ $mtct_lch_forklif1->pict($mtct_lch_forklif1->pict_kiri) }}" alt="File Not Found" class="img-rounded img-responsive">
                                </p>
                              @endif
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- ./box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                    <div class="col-sm-4">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">
                            @if (!empty($mtct_lch_forklif1->pict_belakang))
                              Foto dari sisi belakang (Ada)
                            @else 
                              Foto dari sisi belakang (Tidak Ada)
                            @endif
                          </h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-12">
                              {!! Form::label('pict_belakang', 'Picture Belakang (jpeg,png,jpg)') !!}
                              @if (!empty($mtct_lch_forklif1->pict_belakang))
                                <p>
                                  <img src="{{ $mtct_lch_forklif1->pict($mtct_lch_forklif1->pict_belakang) }}" alt="File Not Found" class="img-rounded img-responsive">
                                </p>
                              @endif
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- ./box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                    <div class="col-sm-4">
                      <div class="box box-primary">
                        <div class="box-header with-border">
                          <h3 class="box-title">
                            @if (!empty($mtct_lch_forklif1->pict_kanan))
                              Foto dari sisi kanan (Ada)
                            @else 
                              Foto dari sisi kanan (Tidak Ada)
                            @endif
                          </h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <div class="row form-group">
                            <div class="col-sm-12">
                              {!! Form::label('pict_kanan', 'Picture Kanan (jpeg,png,jpg)') !!}
                              @if (!empty($mtct_lch_forklif1->pict_kanan))
                                <p>
                                  <img src="{{ $mtct_lch_forklif1->pict($mtct_lch_forklif1->pict_kanan) }}" alt="File Not Found" class="img-rounded img-responsive">
                                </p>
                              @endif
                            </div>
                          </div>
                          <!-- /.form-group -->
                        </div>
                        <!-- ./box-body -->
                      </div>
                      <!-- /.box -->
                    </div>
                  </div>
                  <!-- /.form-group -->
                </div>
                <!-- /.box-footer -->
              @endif
            @endif

            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
            <div class="box-body">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @include('monitoring.mtc.dashboard.imgModal')
@endsection

@section('scripts')
<script type="text/javascript">
  var kd_unit = "{{ $kd_unit }}";
  if(kd_unit === "") {
    $('#form-group-foto').removeAttr('style');
    $('#form-group-foto').attr('style', 'display: none;');
    $('#lok_pict').removeAttr('src');
  } else {
    $('#form-group-foto').removeAttr('style');
    @if (isset($lok_pict))
      $('#lok_pict').attr('src', '{{ $lok_pict }}');
    @else 
      $('#lok_pict').attr('src', null);
    @endif
  }

  function showPict(title, lok_file) {
    $("#imgModal-boxtitle").html(title);
    $('#imgModal-lok_pict').attr('src', lok_file);
  }

  var calcDataTableHeight = function() {
    return $(window).height() * 30 / 100;
  };

  $(document).ready(function(){

    var tableMaster = $('#tblMaster').DataTable({
      "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
      "iDisplayLength": -1,
      "ordering": false, 
      "searching": false,
      "paging": false, 
      responsive: true,
      "scrollY": calcDataTableHeight(),
      "scrollCollapse": true,
      processing: true, 
      "oLanguage": {
        'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
      }, 
      "dom": '<"top"fli>rt<"clear">', 
    });
  });
</script>
@endsection