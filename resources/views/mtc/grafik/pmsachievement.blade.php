@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        PMS Achievement
        <small>PMS Achievement</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> MTC - Laporan</li>
        <li class="active">PMS Achievement</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_filter">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">FILTER</h3>
              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body form-horizontal">
              <div class="form-group">
                <div class="col-sm-2">
                  {!! Form::label('lbltahun', 'Tahun') !!}
                  <select id="filter_status_tahun" name="filter_status_tahun" aria-controls="filter_status" class="form-control select2">
                    @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                      @if ($i == \Carbon\Carbon::now()->format('Y'))
                        <option value={{ $i }} selected="selected">{{ $i }}</option>
                      @else
                        <option value={{ $i }}>{{ $i }}</option>
                      @endif
                    @endfor
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblbulan', 'Bulan') !!}
                  <select name="filter_status_bulan" aria-controls="filter_status" 
                    class="form-control select2">
                      <option value="01" @if ("01" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Januari</option>
                      <option value="02" @if ("02" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Februari</option>
                      <option value="03" @if ("03" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Maret</option>
                      <option value="04" @if ("04" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>April</option>
                      <option value="05" @if ("05" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Mei</option>
                      <option value="06" @if ("06" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juni</option>
                      <option value="07" @if ("07" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Juli</option>
                      <option value="08" @if ("08" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Agustus</option>
                      <option value="09" @if ("09" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>September</option>
                      <option value="10" @if ("10" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Oktober</option>
                      <option value="11" @if ("11" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>November</option>
                      <option value="12" @if ("12" == \Carbon\Carbon::now()->format('m')) selected="selected" @endif>Desember</option>
                    </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('filter_status_plant', 'Plant') !!}
                  <select size="1" id="filter_status_plant" name="filter_status_plant" class="form-control select2">
                    @if ($plant->get()->count() < 1)
                      <option value="-" selected="selected">Pilih Plant</option>
                    @else
                      @foreach($plant->get() as $kode)
                        <option value="{{ $kode->kd_plant }}">{{ $kode->nm_plant }}</option>
                      @endforeach
                    @endif
                  </select>
                </div>
                <div class="col-sm-2">
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display">Display</button>
                </div>
              </div>
              <!-- /.form-group -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
  <script>
    //Initialize Select2 Elements
    $(".select2").select2();

    $('#display').click( function () {
      var tahun = $('select[name="filter_status_tahun"]').val();
      var bulan = $('select[name="filter_status_bulan"]').val();
      var kd_plant = $('select[name="filter_status_plant"]').val();

      if(kd_plant === "-") {
        swal("Kode Plant tidak boleh kosong!", "", "warning");
      } else {
        var urlRedirect = "{{ route('mtctpmss.pmsachievement', ['param','param2','param3']) }}";
        urlRedirect = urlRedirect.replace('param3', window.btoa(kd_plant));
        urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
        urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
        window.location.href = urlRedirect;
      }
    });
  </script>
@endsection