@extends('layouts.app')

<style>
body {font-family: Arial, Helvetica, sans-serif;}

.myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

.myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 999; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0);  /*Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close {
  position: absolute;
  top: 50px;
  right: 50px;
  background-color: #c43c35;
  size: 100px;
  box-sizing: 100px;
  font-size: 200px;
  font-weight: bold;
  transition: 0.3s;
  padding: 20px 20px;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content {
    width: 100%;
  }
}
</style>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  
  <section class="content-header">
      <h1>
      Equipment & Facility
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><i class="glyphicon glyphicon-info-sign"></i> Equipment & Facility</li>
      <li class="active">Monitoring Equipment & Facility</li>
      </ol>
  </section>
  
    <!-- Main content -->
  <section class="content">
     @include('layouts._flash')
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Detail Equipment & Facility</h3>
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
                       <th width="10%"> No MEF </th>
                       <td width="15%">:  <b>{{$mefdetail->first()->no_mef}}</b></td>
                        <th width="10%"> Tanggal </th>
                       <td width="23%">:  {{$mefdetail->first()->tgl_mon}}  </td>
                       <th width="10%"> Lokasi </th>
                      <td width="23%">:  {{$mefdetail->first()->kd_ot}}  </td>
                    </tr>
                    <tr>
                      <th> Status Valve </th>
                      <td>:    
                          @if ($mefdetail->first()->status_valve=='1') <b class="btn-xs btn-success btn-icon-pg" >  OK </b>
                          @elseif ($mefdetail->first()->status_valve=='0') <b class="btn-xs btn-danger btn-icon-pg"  > NG  </b> 
                          @endif  
                      </td>
                      <th>Kondisi Valve </th>
                      <td>
                          @if ($mefdetail->first()->ket_valve_tb=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Bocor<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Bocor<br>
                          @endif 
                          @if ($mefdetail->first()->ket_valve_no=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Normaly Open<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Normaly Open<br>
                          @endif 
                          @if ($mefdetail->first()->ket_valve_tts=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Terganjal Sampah<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Terganjal Sampah<br>
                          @endif 
                      </td>
                      <th></th><td></td>
                    </tr>
                    @if ($mefdetail->first()->status_valve=='0')
                        <tr>
                          <th></th><td></td>
                          <th>Problem Valve</th>
                          <td>:  {{$mefdetail->first()->prob_valve}}</td>
                          <th>DD Valve</th>
                          <td>:  {{$mefdetail->first()->dd_valve}}</td>
                        </tr>
                        <tr>
                          <th></th><td></td>
                          <th>PIC Valve</th>
                          <td>:  {{$mefdetail->first()->cm_valve}}-{{$cmvalve->nama}}</td>
                          <th>C/M Valve</th>
                          <td>
                            @if($mefdetail->first()->pic_valve!="")
                            <img id="myImgvalve" src="{{$img_valve}}" width="100%" class="myImg">
                            @else
                            <img src="/images/no_image.png" width="90" border="0">
                            @endif
                          </td>
                        </tr>
                    @endif 
                    <tr>
                      </td>
                    </tr>
                    <th> Status Pompa </th>
                      <td>:    
                          @if ($mefdetail->first()->status_pompa=='1') <b class="btn-xs btn-success btn-icon-pg" >  OK </b>
                          @elseif ($mefdetail->first()->status_pompa=='0') <b class="btn-xs btn-danger btn-icon-pg"  > NG  </b> 
                          @endif  
                      </td>
                      <th>Kondisi Pompa </th>
                      <td>
                          @if ($mefdetail->first()->ket_pompa_tk=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Kempos<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Kempos<br>
                          @endif 
                          @if ($mefdetail->first()->ket_pompa_man=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Manual & Otomatis Normal<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Manual & Otomatis Normal<br>
                          @endif 
                          @if ($mefdetail->first()->ket_pompa_ct=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Cover Terpasang<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Cover Terpasang<br>
                          @endif 
                      </td>
                        <th></th><td></td>
                    </tr>
                    @if ($mefdetail->first()->status_pompa=='0')
                        <tr>
                          <th></th><td></td>
                          <th>Problem Pompa</th>
                          <td>:  {{$mefdetail->first()->prob_pompa}}</td>
                          <th>DD Pompa</th>
                          <td>:  {{$mefdetail->first()->dd_pompa}}</td>
                        </tr>
                        <tr>
                          <th></th><td></td>
                          <th>PIC Pompa</th>
                          <td>:  {{$mefdetail->first()->cm_pompa}}-{{$cmpompa->nama}}</td>
                          <th>C/M Pompa</th>
                          <td>
                            @if($mefdetail->first()->pic_pompa!="")
                            <img id="myImgpompa" class="myImg" src="{{$img_pompa}}" width="100%">
                             @else
                            <img src="/images/no_image.png" width="90" border="0">
                            @endif
                          </td>
                        </tr>
                    @endif 
                    
                    <th> Status Radar </th>
                      <td>:    
                          @if ($mefdetail->first()->status_radar=='1') <b class="btn-xs btn-success btn-icon-pg" >  OK </b>
                          @elseif ($mefdetail->first()->status_radar=='0') <b class="btn-xs btn-danger btn-icon-pg"  > NG  </b> 
                          @endif  
                      </td>
                      <th>Kondisi Radar </th>
                      <td>
                          @if ($mefdetail->first()->ket_radar_man=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Manual dan Otomatis Normal<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Manual dan Otomatis Normal<br>
                          @endif 
                          @if ($mefdetail->first()->ket_radar_tts=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Terganjal Sampah<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Terganjal Sampah<br>
                          @endif 
                          @if ($mefdetail->first()->ket_radar_stp=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Stoper Tidak Patah / Melengkung<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Stoper Tidak Patah / Melengkung<br>
                          @endif 
                      </td>
                      <th></th><td></td>
                    </tr>
                      @if ($mefdetail->first()->status_radar=='0')
                        <tr>
                          <th></th><td></td>
                          <th>Problem Radar</th>
                          <td>:  {{$mefdetail->first()->prob_radar}}</td>
                          <th>DD Radar</th>
                          <td>:  {{$mefdetail->first()->dd_radar}}</td>
                        </tr>
                        <tr>
                          <th></th><td></td>
                          <th>PIC Radar</th>
                          <td>:  {{$mefdetail->first()->cm_radar}}-{{$cmradar->nama}}</td>
                          <th>C/M Radar</th>
                          <td>
                            @if($mefdetail->first()->pic_radar!="")
                            <img id="myImgradar" class="myImg" src="{{$img_radar}}" width="100%">
                             @else
                            <img src="/images/no_image.png" width="90" border="0">
                            @endif
                          </td>
                        </tr>
                    @endif
                  <tr>
                    <th> Status Bak </th>
                      <td>:    
                          @if ($mefdetail->first()->status_bak=='1') <b class="btn-xs btn-success btn-icon-pg" >  OK </b>
                          @elseif ($mefdetail->first()->status_bak=='0') <b class="btn-xs btn-danger btn-icon-pg"  > NG  </b> 
                          @endif  
                      </td>
                      <th>Kondisi bak </th>
                      <td>
                          @if ($mefdetail->first()->ket_bak_tas=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Ada Sampah<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Ada Sampah<br>
                          @endif 
                          @if ($mefdetail->first()->ket_bak_tal=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Ada Lumpur<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Ada Lumpur<br>
                          @endif 
                          @if ($mefdetail->first()->ket_bak_tb=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Bocor<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Bocor<br>
                          @endif 
                          @if ($mefdetail->first()->ket_bak_tac=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Ada Ceceran Limbah<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Ada Ceceran Limbah<br>
                          @endif 
                      </td>
                      <th></th><td></td>
                    </tr>
                     @if ($mefdetail->first()->status_bak=='0')
                          <tr>
                          <th></th><td></td>
                          <th>Problem Bak</th>
                          <td>:  {{$mefdetail->first()->prob_bak}}</td>
                          <th>DD Bak</th>
                          <td>:  {{$mefdetail->first()->dd_bak}}</td>
                        </tr>
                        <tr>
                          <th></th><td></td>
                          <th>PIC Bak</th>
                          <td>:  {{$mefdetail->first()->cm_bak}}-{{$cmbak->nama}}</td>
                          <th>C/M Bak</th>
                          <td>
                            @if($mefdetail->first()->pic_bak!="")
                            <img id="myImgbak" class="myImg" src="{{$img_bak}}" width="100%">
                             @else
                            <img src="/images/no_image.png" width="90" border="0">
                            @endif
                          </td>
                        </tr>
                    @endif

                    <th> Status Saluran Pit </th>
                      <td>:    
                          @if ($mefdetail->first()->status_spit=='1') <b class="btn-xs btn-success btn-icon-pg" >  OK </b>
                          @elseif ($mefdetail->first()->status_spit=='0') <b class="btn-xs btn-danger btn-icon-pg"  > NG  </b> 
                          @endif  
                      </td>
                      <th>Kondisi Saluran Pit </th>
                      <td>
                          @if ($mefdetail->first()->ket_spit_tas=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Ada Sampah<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Ada Sampah<br>
                          @endif 
                          @if ($mefdetail->first()->ket_spit_tal=='T') 
                          <i class="fa fa-check" style="font-size:20px;color:green"></i> Tidak Ada Lumpur<br>
                          @else
                          <i class="fa fa-close" style="font-size:20px;color:red"></i> Tidak Ada Lumpur<br>
                          @endif
                      </td>
                        <th></th><td></td>
                    </tr>   
                        @if ($mefdetail->first()->status_spit=='0')
                          <tr>
                            <th></th><td></td>
                          <th>Problem Saluran Pit</th>
                          <td>:  {{$mefdetail->first()->prob_spit}}</td>
                          <th>DD Saluran Pit</th>
                          <td>:  {{$mefdetail->first()->dd_spit}}</td>
                        </tr>
                        <tr>
                          <th></th><td></td>
                          <th>PIC Saluran Pit</th>
                          <td>:  {{$mefdetail->first()->cm_spit}}-{{$cmspit->nama}}</td>
                          <th>C/M Saluran Pit</th>
                          <td>
                            @if($mefdetail->first()->pic_spit!="")
                            <img id="myImgspit" src="{{$img_spit}}" class="myImg" width="100%">
                             @else
                            <img src="/images/no_image.png" width="90" border="0">
                            @endif
                          </td>
                        </tr>
                    @endif                 
                    
                </tbody>
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


  <div id="myModal" class="modal">
  <span  style="size:100px;" class="close">&times;</span>
  <img class="modal-content" id="img01">

</div>
@endsection




@section('scripts')
<script>
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal - use its "alt" text as a caption
var imgvalve = document.getElementById("myImgvalve");
var imgpompa = document.getElementById("myImgpompa");
var imgradar = document.getElementById("myImgradar");
var imgbak = document.getElementById("myImgbak");
var imgspit = document.getElementById("myImgspit");
var modalImg = document.getElementById("img01");

imgvalve.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}

imgpompa.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}
imgradar.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}

imgbak.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}
imgspit.onclick = function(){
  modal.style.display = "block";
  modalImg.src = this.src;
}


// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>


                            
                                  

@endsection