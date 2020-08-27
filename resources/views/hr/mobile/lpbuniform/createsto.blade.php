@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	
	<section class="content-header">
      <h1>  Stock Opname </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
       
        <li><a href="{{ route('mobiles.indexlpbuni') }}"><i class="fa fa-files-o"></i> Laporan Mutasi Bulanan</a></li>
		  <li class="active">Tambah Stock Opname</li>
      </ol>
    </section>
	
	
    

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Tambah Stock Opname</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
     <div class="box-body">

{!! Form::open(['url' => route('mobiles.storesto', $datasto->first()->kd_uni), 'method' => 'post', 'files'=>'true', 'class'=>'form-horizontal']) !!}


            <div class="form-group{{ $errors->has('kd_uni') ? ' has-error' : '' }}">
            {!! Form::label('kode', 'Kode Barang', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
            {!! Form::text('kd_uni', ($datasto->first()->kd_uni), ['class'=>'form-control' , 'readonly' => 'true']) !!}
            {!! $errors->first('kd_uni', '<p class="help-block">:message</p>') !!}
            </div>
            </div>

            <div class="form-group{{ $errors->has('namauni') ? ' has-error' : '' }}">
            {!! Form::label('namauni', 'Nama Barang', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
            {!! Form::text('namauni', $namauni->first()->desc_uni, ['class'=>'form-control' , 'readonly' => 'true']) !!}
            {!! $errors->first('namauni', '<p class="help-block">:message</p>') !!}
            </div>
            </div>

            {!! Form::hidden('bulan', $datasto->first()->bulan, ['class'=>'form-control' , 'readonly' => 'true']) !!}
             {!! Form::hidden('tahun', $datasto->first()->tahun, ['class'=>'form-control' , 'readonly' => 'true']) !!}

        
            <div class="form-group{{ $errors->has('bulan') ? ' has-error' : '' }}">
            {!! Form::label('bulan', 'Bulan, Tahun', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
            {!! Form::text('periode', ($Bulan . ', ' . $datasto->first()->tahun ), ['class'=>'form-control' , 'readonly' => 'true']) !!}
            {!! $errors->first('bulan', '<p class="help-block">:message</p>') !!}
            </div>
            </div>

             

<hr>
            
            <div class="form-group{{ $errors->has('sto') ? ' has-error' : '' }}">
            {!! Form::label('sto', 'Stok Barang', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
            {!! Form::number('s_akhir', $datasto->first()->s_akhir, ['class'=>'form-control',  'readonly' => 'true',  'id'=>'s_akhir']) !!}
            {!! $errors->first('sto', '<p class="help-block">:message</p>') !!}
            </div>
            </div>

            


            <div class="form-group{{ $errors->has('sto') ? ' has-error' : '' }}">
            {!! Form::label('sto', 'Jumlah STO', ['class'=>'col-md-2 control-label']) !!}
            <div class="col-md-4">
            {!! Form::number('sto', $datasto->first()->sto, ['class'=>'form-control', 'id'=>'inputsto']) !!}

            {!! $errors->first('sto', '<p class="help-block">:message</p>') !!}
            </div>
            </div>

            <div class="form-group{{ $errors->has('sto') ? ' has-error' : '' }}">
            {!! Form::label('sto', 'Selisih', ['class'=>'col-md-2 control-label', 'readonly' => 'true']) !!}
            <div class="col-md-4">
            {!! Form::number('selisih', $datasto->first()->selisih, ['class'=>'form-control',  'readonly' => 'true', 'id'=>'selisih']) !!}
            {!! $errors->first('sto', '<p class="help-block">:message</p>') !!}
            </div>
            </div>

 <div class="modal-footer">
            <div class="form-group">
            <div class="col-md-4 col-md-offset-2"> 

    
                {!! Form::submit('Simpan', ['class'=>'btn btn-primary']) !!}
    
          
            <a class="btn btn-default" href="{{ route('mobiles.indexmutasiuni') }}"> Batal </a> 
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
@endsection
@section('scripts')
<script type="text/javascript" >

$(document).ready(function() {
      $('#inputsto').keyup(function() {
            var s_akhir = parseInt($('#s_akhir').val());
            var inputsto = parseInt($('#inputsto').val());
            var nilaiselisih =  inputsto - s_akhir;
       
            $('#selisih').val(nilaiselisih);

      });

       $('#inputsto').click(function() {
            var s_akhir = parseInt($('#s_akhir').val());
            var inputsto = parseInt($('#inputsto').val());
            var nilaiselisih =  inputsto - s_akhir;
       
            $('#selisih').val(nilaiselisih);

      });
});     
      
</script>



@endsection