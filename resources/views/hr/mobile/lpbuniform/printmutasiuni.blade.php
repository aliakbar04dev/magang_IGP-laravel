<!DOCTYPE html>
<html>
<head>
  <title>Laporan Mutasi Uniform</title>

   <style>
@page { 
  size: A4; 
  margin-left: 0.5cm;
  margin-right: 0.5cm;
  margin-top: 0.5cm;
  margin-bottom: 0.5cm;

}

thead {display: table-header-group;}
 
    h1 {
        font-weight: bold;
        font-size: 20pt;
        text-align: center;
    }
 
    table {
        border-collapse: collapse;
        width: 95%;
    }
 
    .table th {
        padding: 8px 8px;
        border:1px solid #000000;
        text-align: center;
    }
 
    .table td {
        padding: 2px 2px;
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

      
         
   {{ csrf_field() }}
     
<br>

                <table class="table">
                <thead >
                    <tr> 
                      <th colspan="2"><img src="images/logo.png" width="85" border="0"> </th>
                      <td colspan="9" align="center"> 
                        <h2>  PT. Inti Ganda Perdana </h2> 
                     <font size="10px" > Jl. Pegangsaan Dua Blok A-3, Km 1,6 Kelapa Gading,<br>Jakarta Utara, DKI Jakarta, 14250 - Indonesia <br>
                      Phone: 021 - 4602755 (Ext. 184) <br>
                      Fax: 021 - 4602765  </font> </td>
                    <tr>
                      <th colspan="11">
                         <h2 align="center">Laporan Mutasi Barang</h2></th> </tr>
                    </tr>

                <!--    <tr>
                      <th colspan="2">
                        PT    
                      </th>
                      <td colspan="7">  {{$PT}}</td>
                    </tr>

                    <tr>
                      <th colspan="2">
                        Bulan    
                      </th>
                      <td colspan="7">  {{$Bulan}}</td>
                    </tr>

                    <tr>
                      <th colspan="2">
                        Tahun    
                      </th>
                      <td colspan="7">  {{$Tahun}}</td>
                    </tr> -->

                
                </thead>
                <tbody>
                  
              @foreach($mutasi as $key=>$item)
                <tr>
                <td align="center">{{++$key}}</td>
                <td align="center">{{$item->kd_uni}}</td>
                <td>{{$item->desc_uni}}</td>
                <td align="center">
                @if ($item->bulan=='01') 
                    Januari 
                @elseif  ($item->bulan=='02') 
                    Februari 
                @elseif  ($item->bulan=='03') 
                     Maret 
                @elseif  ($item->bulan=='04') 
                     April 
                @elseif  ($item->bulan=='05') 
                     Mei 
                @elseif  ($item->bulan=='06') 
                     Juni 
                @elseif  ($item->bulan=='07') 
                     Juli 
                @elseif  ($item->bulan=='08') 
                     Agustus 
                @elseif  ($item->bulan=='09') 
                    September 
                @elseif  ($item->bulan=='10') 
                     Oktober 
                @elseif  ($item->bulan=='11') 
                     November 
                @elseif  ($item->bulan=='12') 
                     Desember 
                @endif
                </td>
                <td align="center">{{$item->tahun}}</td>
                <td align="center">{{$item->s_awal}}</td>
                <td align="center">{{$item->in}}</td>
                <td align="center">{{$item->out}}</td>
                <td align="center">{{$item->s_akhir}}</td>
                <td align="center">{{$item->sto}}</td>
                 <td align="center">{{$item->selisih}}</td>
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