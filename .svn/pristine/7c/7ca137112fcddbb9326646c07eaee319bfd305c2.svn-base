@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>Laporan Mutasi Barang</h1>
      <ol class="breadcrumb">
          <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active"><i class="fa fa-files-o"></i> Laporan Mutasi Barang </li>
      </ol>
   </section>

      <!-- Main content -->
   <section class="content">
      
@include('layouts._flash')
  <div class="row" id="field_detail">
    <div class="col-md-12">
      <div class="box box-primary">
       <div class="box-header with-border">
          <h3 class="box-title">Laporan Mutasi Uniform </h3>
          <div class="box-tools pull-right">
             <button type="button" class="btn btn-box-tool" data-widget="collapse">
                <i class="fa fa-minus"></i>
             </button>
             <!--    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
          </div>
       </div>
    
      <div class="box-body">
       {!! Form::open(['url' => route('mobiles.printmutasiuni'), 'method' => 'post',  'id'=>'form_id']) !!}
              <p>  <a class="btn btn-primary" type="submit" href="{{ route('mobiles.createmutasi') }}" id="printlmb" >
                  <span class="fa fa-plus"></span> Tambah Laporan Mutasi Bulanan </a>
              </p>

                <!--<div class="box-header">
                    <p>  
                      <a class="btn btn-primary" type="submit" href="{{ route('mobiles.printmutasiuni') }}" id="printlmb" target="_blank"> <span class="fa fa-print"></span> Print Laporan Mutasi Uniform</a>
                    </p>
                </div> -->

                     
             <div class="col-sm-2">   
                {!! Form::label('filter_seragam', 'PT') !!}<br>
                  <select size="1" name="filter_pt" aria-controls="filter_status_apr" 
                    class="form-control select2" style="width: 150px;">
                      <option value="ALL" selected="selected">ALL</option>
                      <option value="IGP">IGP</option>
                      <option value="GKD">GKD</option>
                      <option value="ANDIN">ANDIN</option>
                      <option value="AGI">AGI</option>
                    </select>
                  </label>
                </div>
            
           
            <div class="col-sm-2">
              {!! Form::label('filter_tahun', 'Tahun') !!}
              <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
              class="form-control select2">
               <option value="ALL" selected="selected">ALL</option>
                @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                  @if ($i == \Carbon\Carbon::now()->format('Y'))
                    <option value={{ $i }} selected="selected" >{{ $i }}</option>
                  @else
                    <option value={{ $i }}>{{ $i }}</option>
                  @endif
                @endfor
              </select>
            </div>



            <div class="col-sm-2">
              {!! Form::label('filter_bulan', 'Bulan') !!}
              <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" class="form-control select2">
                <option value="ALL" selected="selected">ALL</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
              </select>
            </div>

             <div class="col-sm-2">
              {!! Form::label('filter_katagori', 'Jenis Barang') !!}
              <select id="filter_katagori" name="filter_katagori" aria-controls="filter_status" 
              class="form-control select2">
                <option value="">Semua Jenis</option>
                <option value="Baju">Baju</option>
                <option value="Celana">Celana</option>
                <option value="Helm">Helm</option>
                <option value="Sepatu">Sepatu</option>
                <option value="Topi">Topi</option>
              </select>
            </div>



          <!-- <div class="col-sm-2">   <br>  <a class="btn btn-primary glyphicon glyphicon-search " href="{{ route('mobiles.createlpbuni') }}">  </a> </div> -->

         <br> 
            <button type="submit" class="btn btn-primary" >
             <span class="fa fa-print"></span> Print Laporan Mutasi Uniform 
            </button> <br>
            <b style="color: red;">*Pilih filter lebih dulu</b>
          
  {!! Form::close() !!}
          <br>
          <hr>

          <table id="tblDetail" class="table table-bordered table-striped  table-sm table-dark table-hover" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th>No</th>
                {{-- <th>Kode Uniform</th> --}}
                <th>Nama Uniform</th>
                <th>Bulan</th> 
                <th>Tahun</th>                  
                <th>Saldo Awal</th>
                <th>Barang Masuk</th> 
                <th>Barang Keluar</th>
                <th>Saldo Akhir</th>
                <th>STO</th>
                <th>Selisih</th>
                <th>Add STO</th>
              </tr>
            </thead>
          </table>       
        </div>
                      <!-- ./box-body -->
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

  $(document).ready(function(){

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
      // "searching": false,
      // "scrollX": true,
      // "scrollY": "700px",
      // "scrollCollapse": true,
      // "paging": false,
      // "lengthChange": false,
      // "ordering": true,
      // "info": true,
      // "autoWidth": false,
      "order": [[1, 'asc']],
      processing: true,
      serverSide: true,
    
      ajax: "{{ route('mobiles.dashboardmutasiuni') }}",
      columns: [
        {data: null, name: null, orderable: false, searchable: false},
        /*{data: 'kd_uni', name: 'muniform2.kd_uni'},*/
        {data: 'desc_uni', name: 'muniform2.desc_uni'},
        {data: 'bulan', name: 'bulan'},
        {data: 'tahun', name: 'tahun'},
        {data: 's_awal', name: 's_awal'},
	 	    {data: 'in', name: 'in'},
		    {data: 'out', name: 'out'},
		    {data: 's_akhir', name: 's_akhir'},
		    {data: 'sto', name: 'sto'},
        {data: 'selisih', name: 'selisih'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
      ]
    });

     $('#filter_katagori').on('keyup', function(){
        tableDetail.column(1).search(this.value).draw();   
    }); 


    $('#filter_katagori').on('change', function(){
        tableDetail.column(1).search(this.value).draw();   
    }); 
	
  $(function() {
      $("#tblDetail").on('preXhr.dt', function(e, settings, data) {
        data.pt = $('select[name="filter_pt"]').val();
        data.tahun = $('select[name="filter_tahun"]').val();
        data.bulan = $('select[name="filter_bulan"]').val();
     //   data.katagori = $('select[name like "filter_katagori"]').val();
      });

      $('select[name="filter_pt"]').change(function() { tableDetail.ajax.reload(); });
      $('select[name="filter_tahun"]').change(function() { tableDetail.ajax.reload();  });
      $('select[name="filter_bulan"]').change(function() { tableDetail.ajax.reload();  }); 
      //$('select[name="filter_katagori"]').change(function() { tableDetail.ajax.reload();  });     
  });

  });
</script>
@endsection