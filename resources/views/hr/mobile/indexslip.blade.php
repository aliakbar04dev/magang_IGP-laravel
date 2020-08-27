@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Slip Gaji & Lembur
        <small>Slip Gaji & Lembur</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Employee Info</li>
        <li class="active"><i class="fa fa-files-o"></i> Slip Gaji & Lembur</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">        
    		<div class="box-body form-horizontal">
          <div class="form-group">
            <div class="col-sm-2">
                {!! Form::label('lbltahun', 'Tahun') !!}
                <select name="filter_status_tahun" aria-controls="filter_status" 
                  class="form-control select2">
                  @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-2; $i--)
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
          </div>
    		  <div class="form-group">
    		    <div class="col-sm-2">
              {!! Form::label('lblslip', 'Slip') !!}
              <select name="filter_status_slip" aria-controls="filter_status" class="form-control select2">
                <option value="GAJI" selected="selected">Gaji</option>
                <option value="LBR">Lembur</option>
                <option value="HAT">HAT</option>
              </select>
            </div>
            <div class="col-sm-2">
              {!! Form::label('lblview', ' ') !!}
              <button id="btn-view" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="View Slip">View Slip</button>
            </div>
    		  </div>
    		  <!-- /.form-group -->
    		</div>
    		<!-- /.box-body -->

        {{-- <div class="box-body" id="id-box"> --}}
          {{-- @include ('hr.mobile.slipgaji') --}}
        {{-- </div> --}}
        <!-- /.box-body -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection

@section('scripts')
<script type="text/javascript">

$("#btn-view").click(function(){
  var tahun = $('select[name="filter_status_tahun"]').val();
  var bulan = $('select[name="filter_status_bulan"]').val();
  var slip = $('select[name="filter_status_slip"]').val();
  var urlRedirect = '{{ route('mobiles.viewslip', ['param', 'param2', 'param3']) }}';
  urlRedirect = urlRedirect.replace('param3', window.btoa(slip));
  urlRedirect = urlRedirect.replace('param2', window.btoa(bulan));
  urlRedirect = urlRedirect.replace('param', window.btoa(tahun));
  // window.location.href = urlRedirect;
  window.open(urlRedirect, '_blank');
  // $("#id-box").load(urlRedirect); 
});
</script>
@endsection