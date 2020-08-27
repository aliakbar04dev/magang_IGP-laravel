<!DOCTYPE html>
<html>
<head>
  <title>LPB Uniform</title>

   <style>
@page { size: A4 }
 
    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }
 
    table {
        border-collapse: collapse;
        width: 100%;
    }
 
    .table th {
        padding: 8px 8px;
        border:1px solid #000000;
        text-align: center;
    }
 
    .table td {
        padding: 3px 3px;
        border:1px solid #000000;
    }
 
    .text-center {
        text-align: center;
    }
</style>
 </head>




<body>
 
        
        <!-- form start -->
     <div class="box-body">
		<div class="form-group">
  
			<div >


         <table style="margin-top-top: 1px; margin-left: 1px">
                <thead >
                    <tr> 
                      <th rowspan="2" align="left" width="110px"><img src="images/logo.png" width="100" border="0"> </th>
                      <td align="center">
                         <font size="30px" > <b> PT. Inti Ganda Perdana </b> </font> </td>
                      </td>
  
                    </tr>
                    <tr><td align="center"><font size="9px" > Jl. Pegangsaan Dua Blok A-3, Km 1,6 Kelapa Gading,<br>Jakarta Utara, DKI Jakarta, 14250 - Indonesia <br>
                      Phone: 021 - 4602755 (Ext. 184) <br>
                      Fax: 021 - 4602765  </font></td></tr>


      </thead></table>
<br>
        <hr> <center>
  <h2>Laporan Penerimaan Barang</h2> </center>
  <hr>
         
	 {{ csrf_field() }}
                            <table >
                                <tbody>
                                    <tr>
                                        <th align="left">  No. LPB  </th>
                                        <td>:  {{$barangmasuk1->first()->nolpb}} </td>
                                    </tr>
                                    <tr><th></th><td></td></tr>

                                   <tr>
                                         <th align="left">  Tanggal LPB </th>
                                        <td>:  {!! date('l, d F Y', strtotime($barangmasuk1->first()->tgl_lpb)); !!} </td>
                                    </tr>
                                     <tr><th></th><td></td></tr>

                                    <tr>
                                          <th align="left">  Supplier </th>
                                        <td>:  {{$barangmasuk1->first()->supplier}} </td>
                                    </tr>
                                      <tr><th></th><td></td></tr>

                                     <tr>
                                       <th align="left"> No. Referensi </th>
                                        <td>:  {{$barangmasuk1->first()->noref}} </td>
                                    </tr>
                                     <tr><th></th><td></td></tr>

                                    
                                </tbody>
                            </table>
<br>
<br>

                <table class="table">
                <thead >
                    <tr>

                        <th>No</th>
                        <th>Item</th>
                        <th>Qty</th>
                       
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
          

  
  
  


</div>
</div>


      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  </body>
  </html>