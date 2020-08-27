@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Laporan Pemakaian Bahan Kimia
        <small>Laporan Pemakaian Bahan Kimia</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="fa fa-files-o"></i> Laporan</li>
        <li class="active"><i class="fa fa-files-o"></i> Pemakaian Bahan Kimia</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="row" id="field_filter">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body form-horizontal">
              <div class="form-group">
                <div class="col-sm-2">
                  {!! Form::label('filter_tahun', 'Tahun') !!}
                  <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
                  class="form-control select2">
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
                  {!! Form::label('filter_bulan', 'Bulan') !!}
                  <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
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
                  {!! Form::label('lblusername2', 'Action') !!}
                  <button id="btn-display" name="btn-display" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Display Laporan">Display Laporan</button>
                </div>
              
               
              </div>
              <!-- /.form-group -->
            </div>

             <div class="box-body form-horizontal">
              <div class="form-group">
                  <div class="col-sm-2">
                        {!! Form::label('tgl', 'Tanggal') !!}
                        {!! Form::date('tgl', \Carbon\Carbon::now(), ['class'=>'form-control','placeholder' => 'Tgl Awal', 'id' => 'tgl']) !!}
                  </div>
                  <div class="col-sm-2" >
                  {!! Form::label('lblusername3', 'Action') !!}
                  <button id="btn-proses" name="btn-proses" type="button" class="form-control btn btn-warning" data-toggle="tooltip" data-placement="top" title="Display Grafik">Display Grafik</button>
                  </div>
               </div>
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
<script type="text/javascript">
  document.getElementById("filter_tahun").focus();

  $(document).ready(function(){
    $('#btn-display').click( function () {
      var tahun = $('select[name="filter_tahun"]').val();
      var bulan = $('select[name="filter_bulan"]').val();
      var urlRedirect = "{{ route('ehsenvreps.monitoring_pkimia', ['param','param2']) }}";
      urlRedirect = urlRedirect.replace('param2', bulan);
      urlRedirect = urlRedirect.replace('param', tahun);
      // window.location.href = urlRedirect;
    window.open(urlRedirect, '_blank');
    });

    $('#btn-proses').click( function () {
    var str = $('input[name="tgl"]').val();
    var tahun = str.substring(0,4);
    var bulan = str.substring(5,7);
    var tgl = str.substring(8.10);
    var param = tahun + "" + bulan + "" + tgl; 
    var url = "{{ route('ehsenvreps.grafik_pkimia', 'param') }}";
    url = url.replace('param', param);
   window.open(url, '_blank');
    });
  });
</script>
@endsection