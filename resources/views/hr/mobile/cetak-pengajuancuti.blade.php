
<body>            
        <table style="margin-top-top: 1px; margin-left: 1px;">
                <thead >
                    <tr> 
                      <th rowspan="2" align="left" width="110px"><img src="images/logo.png" width="100" border="0"> </th>
                      <td align="center">
                         <font size="25px" > <b> PT. Inti Ganda Perdana </b> </font> </td>
                      </td>
  
                    </tr>
                    <tr><td align="center"><font size="9px" > Jl. Pegangsaan Dua Blok A-3, Km 1,6 Kelapa Gading,<br>Jakarta Utara, DKI Jakarta, 14250 - Indonesia <br>
                      Phone: 021 - 4602755 (Ext. 184) <br>
                      Fax: 021 - 4602765  </font></td></tr>


      </thead></table>
<br>
        <hr> <center>
  <h2>Bukti Persetujuan Cuti</h2> </center>
  <hr>
        
        <!-- form start -->
     <div class="box-body">
    <div class="form-group">
  
      <div class="table-responsive">
        <form method="POST" accept-charset="UTF-8" style="display:inline">
          {{ csrf_field() }}
         <table>
                                <tbody>
                                       
        </tr>
        <tr>
                <td style="text-align:left;"><b>No. CUTI</b></td>
                <td>:  <b>{{ $cuti->first()->no_cuti }}</b>   </td>
            </tr>
            <tr>
                <td style="width:40%;text-align:left;"><b>Nama PT</b></td>
                <td style="width:60%;">:  {{ $cuti->first()->kd_pt }}</td>
            </tr>  
            <tr>
                <td style="width:40%;text-align:left;"><b>NPK</b></td>
                <td style="width:60%;">:  {{ $cuti->first()->npk }} </td>
            </tr>
            <tr>
                <td style="width:40%;text-align:left;"><b>Nama</b></td>
                <td style="width:60%;">:  {{ $cuti->first()->nama }}</td>
            </tr>  
            <tr>
                <td style="width:40%;text-align:left;"><b>Nama Atasan</b></td>
                <td style="width:60%;">:  {{ $namaAtasan }}</td>
            </tr>  
            <tr>
                <td style="text-align:left;"><b>Bagian<b></td>
                <td>:  {{ $cuti->first()->desc_dep }}</td>
            </tr>
            <tr>
                <td style="text-align:left;"><b>Status</b></td>
                @if($cuti->first()->status =='1' || $cuti->first()->status =='3')         
                <td>:  <b style='color:green;'>DISETUJUI</b></td> 
                @else   
                <td>:  <b style='color:red;'>DITOLAK</b></td>   
                @endif
            </tr> 
            <tr >
                <td style="padding : 10px;"></td>
            </tr>

            @foreach ($cuti2 as $datatgl)
            <tr>
                <td style="text-align:left;"><b><?php $date=date_create($datatgl->tglcuti); echo date_format($date,"d/m/Y"); ?><b></td>
                    <td >: {{$datatgl->desc_cuti}}
                </tr>
            @endforeach

            <tr>
                <td style="padding : 10px;"></td>
            </tr> 
            <tr>
                <td style="text-align:left;" colspan=2><center><b>Disetujui pada tanggal<b><b>:  <?php $date=date_create($cuti->first()->tglapprov); echo date_format($date,"d/m/Y"); ?></b></center></td>
            </tr>
                    </table>

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
  </body>
  