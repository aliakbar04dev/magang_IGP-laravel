@extends('layouts.app')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
	
	<section class="content-header">
      <h1>
        Detail Laporan Penerimaan Barang
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Laporan Penerimaan Barang</li>
      
		  <li class="active">Detail LPB </li>
      </ol>
    </section>
	
	
    

    <!-- Main content -->
    <section class="content">
      @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detail {{$barangmasuk1->first()->nolpb}}</h3>
        </div>
        <!-- /.box-header -->
        
        <!-- form start -->
     <div class="box-body">
  <div class="form-group">
  
  <div class="table-responsive">
  
<form method="POST" accept-charset="UTF-8" style="display:inline">
     {{ csrf_field() }}
                            <table class="table">
                                <tbody>
                                 <tr>
                                        <th> No. LPB </th>
                                        <td>:  {{$barangmasuk1->first()->nolpb}} </td>
                                    </tr>

                                   <tr>
                                        <th> Tanggal LPB </th>
                                        <td>:  {!! date('l, d F Y', strtotime($barangmasuk1->first()->tgl_lpb)); !!} </td>
                                    </tr>

                                    <tr>
                                        <th> Supplier </th>
                                        <td>:  {{$barangmasuk1->first()->supplier}} </td>
                                    </tr>

                                     <tr>
                                        <th> No. Referensi </th>
                                        <td>:  {{$barangmasuk1->first()->noref}} </td>
                                    </tr>                            
                                </tbody>
                            </table>


                <table class="table  table-bordered table-dark">
                <thead class="thead-dark">
                    <tr align="center">

                        <th width="50px" > <center> No </center></th>
                        <th > <center> Item </center></th>
                        <th > <center> Qty </center></th>
                       
                    </tr>
                </thead>
                <tbody>
                  
                    @foreach($barangmasuk2 as $key=>$item)
                <tr>
                <td align="center">{{++$key}}</td>
                <td>{{$item->desc_uni}}</td>
                <td align="center">{{$item->qty}}</td>
                </tr>
                          
                         
                    @endforeach

                    
                    

                </tbody>
            </table>
          <div class="modal-footer">


          
            <a  href="{{route('mobiles.printlpbuni', $detail->nolpb)}}" class="btn btn-primary glyphicon glyphicon-print" target="_blank">  Cetak</a>
            <a class="btn  btn-default glyphicon glyphicon-remove-sign" href="{{ route('mobiles.indexlpbuni') }}">  Batal </a>
          
                       </div> 
                                  </form>








               </div>

</div>
</div>


      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection