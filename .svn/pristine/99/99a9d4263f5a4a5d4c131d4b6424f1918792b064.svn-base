@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	
	<section class="content-header">
      <h1> Mutasi Bulanan </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('mobiles.indexlpbuni') }}"><i class="fa fa-files-o"></i> Laporan Mutasi Bulanan</a></li>
		  <li class="active">Tambah Laporan Mutasi Bulanan</li>
      </ol>
    </section>

    <!-- Main content -->
  <section class="content">
    @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Mutasi Bulanan</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
     <div class="box-body">
      {!! Form::open(['url' => route('mobiles.storemutasi'), 'method' => 'post', 'class'=>'form-horizontal']) !!} 

         <div class="col-md-2">
            {!! Form::label('bulan', 'Bulan') !!}
            <input type="text" name="blnmutasi" value="{{$Bulan}}" class="form-control" readonly="true" >  
            <input type="hidden" name="blnmutasi" value="{{$bulan}}" class="form-control" readonly="true" >  
             {{--   <select id="blnmutasi" name="blnmutasi" aria-controls="filter_status" class="form-control" readonly="true"  >
            <option value="ALL" selected="selected">ALL</option>
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
          </select> --}}
        </div>

        <div class="col-md-2">
            {!! Form::label('tahun', 'Tahun') !!}
            <input type="text" name="thnmutasi" value="{{$tahun}}" class="form-control" readonly="true" >
        </div>
  <br>
  <br>
  <br>
  <hr>
    <div class="row">   
        <div class="col-md-12">
            <table class="table table-hover" id="dinamis">
                 <thead>
                    <tr>
                        <th> <center> No </center></th>
                        <th> <center>Item </center></th>
                        <th> <center>Saldo Awal </center></th>
                        <th>
                         {{--    <button type="button" class="btn btn-blue add-row">+</button></th> --}}
                    </tr>
                </thead>
                <tbody> 
                @foreach($barangmasukyes as $key=>$item)
                    <tr>
                        <td align="center"> {{++$key}} </td>
                        <td>
                         <input name="uniform_{{ $loop->iteration }}" id="uniform_{{ $loop->iteration }}" class="form-control" size="3px" width="5px" value="{{$item->kd_uni}}" title="{{$item->nm_uni}}" readonly="true" type="hidden"/>
                         <input name="uniformname" class="form-control" size="3px" width="5px" value="{{$item->desc_uni}}"  readonly="true" />
                        </td>
                        <td>
                            <input width="3px" class="form-control" type="number" name="sawal_{{ $loop->iteration }}" id="sawal_{{ $loop->iteration }}"  value="{{$item->s_akhir}}" >  
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger delete-row icon-trash glyphicon glyphicon-trash"></button></td>
                    </tr>
                     @endforeach
                       {!! Form::hidden('jml_line', $barangmasukyes->count(), ['class'=>'form-control', 'readonly'=>'readonly', 'id' => 'jml_line']) !!}

                </tbody>
            </table>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary glyphicon glyphicon-floppy-saved"> Simpan</button>
        </div>
      </div>
     </div>
     {!! Form::close() !!}		
    </div>
   </div>
  </div>
      <!-- /.box -->
 </section>
    <!-- /.content -->
</div>
  <!-- /.content-wrapper -->


<script src="/js/jquery-1.11.1.min.js"></script>
<script>
$(function () {
    var i = 4;
    $('#dinamis').on('click', '.delete-row', function () {
        $(this).parent().parent().remove();
         i--;  
    });
})
</script>
@endsection