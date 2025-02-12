@extends('monitoring.mtc.layouts.app3')
<style type="text/css">
  body {
    background-image: url("{{ asset('images/warehouse_bg.jpg') }}");
  }

  .atasdashboard{
    width: 100%; 
    height:100px; 
    padding:0px; 
    margin-left:-10px;
  }

  .box{
    position: relative;
  text-align: center;
  background:none;
        /* Make the width of box same as image */
}
.centered {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}

.garistengah{ 
  
  border:         none;
  border-left:    2px solid white;
  height:         150px;
  width:          1px;     
}

.imagepower{
  height:400px;
  width: 400px;
}

.imagebtn{
  height: 75px;
  width: 150px;
}

.imagepower2{
  height: 400px;
  width: 400px;
}



  @media only screen and (min-width: 600px) {

  .atasdashboard{
    width: 100%; 
    height:100px; 
    padding:0px; 
    margin-left:-50px;
  }

  
  .bagianbawah{
    background-color: white;
    border-radius: 10px;
    width:80%;
   margin:auto;
  }

  .dashed { border-radius:15px; width:100%;height:530px;background-color: white;}

  .garisinfo{
    margin-left:10px;
  }

  .menu{
    font-size: 30px;
    color:white;
  }

  .imagelogo{
    margin-top:-10px;
    margin-left:30px;
    height:100px; 
    width:100px;
  }

  #tblMaster{
    margin-left: -20px;
  }

  .huruf{
    font-size: 25px;
    text-transform: uppercase;
  }

 .backbutton{
    font-size: 30px;
    text-transform: uppercase;
    float:right;
    height:40px;
    margin-top:-40px;
  }
  
}

@media only screen and (max-width: 599px) {


.menu{
  font-size: 14px;
  color:white;
}

.imagelogo{
    margin-top:15px;
    margin-left:30px;
    height:50px; 
    width:50px;
  }

  .huruf{
    font-size: 14px;
    margin-top:10px;
    text-transform: uppercase;
  }

  .backbutton{
    font-size: 30px;
    text-transform: uppercase;
    float:right;
    height:40px;
    margin-top:-35px;
  }

}



  
</style>
@section('content')
  <div class="container4">
    <div class="row" id="box-body" name="box-body">
          {{-- <div class="box-header" style="margin-bottom:-30px;">
            <center style="padding:0px; margin:0px;"> <img src="{{ asset('images/atas-db.png') }}" class="atasdashboard"></center> --}}
            {{-- <center><h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;color: white"><strong>DASHBOARD SMART MAINTENANCE</strong></h3></center> --}}
          {{-- </div> --}}

          
          <!-- /.box-header -->

          <div class="box-body tampilbawah" >
                <div class="row">
                    <div class="col-xl-12" >
                        <img src="{{ asset('images/logosmart.png') }}" class="imagelogo" align="left">
                        <br>
                            <div class="alert alert-danger alert-dismissible" style="height:40px; padding:0px 10px; background-color:#ff7701 !important;">
                                    <p class="huruf" >POWER & UTILITY</p>
                                    
                                    <div class="backbutton" onclick="onBack()">
                                        <button type="button" class="btn bg-navy margin" style="width:70px;"><i class="fa fa-chevron-circle-left"></i></button>
                                      
                                    </div>
                            </div>
                            <br>
                            <div class="col-md-12 table-responsive " width="100%" style=" height:600px; margin-top:8%; margin-bottom:10%;">
                              <br>
                             <div class="box-body">

                              <table width="100%">
                                <tr>
                                  <td width="25%">
                                      <div class="dashed" >
                                          <center><img src="{{ asset('images/power1.png') }}" class="imagepower" ></center>
                                          <br>
                                          <center><img src="{{ asset('images/mdb1.png') }}" class="imagebtn" id="btn-dpm-1"></center>
                                      </div>
                                  </td>
                                  <td width="5%">
                                  </td>
                                  <td width="40%">
                                      <div class="dashed">
                                          <center><img src="{{ asset('images/power2.png') }}" class="imagepower2" ></center>
                                          <br>
                                          <center><img src="{{ asset('images/mdb2.png') }}" class="imagebtn" id="btn-dpm-2"> &nbsp;
                                            &nbsp;&nbsp;
                                            &nbsp;
                                            &nbsp;
                                            &nbsp;
                                            &nbsp;
                                            &nbsp;
                                            &nbsp;
                                            &nbsp;
                                            &nbsp;
                                            <img src="{{ asset('images/mdb3.png') }}" class="imagebtn" id="btn-dpm-3"></center>
                                        </div>
                                  </td>
                                  <td width="5%">
                                    </td>
                                  <td width="25%">
                                      <div class="dashed">
                                          <center><img src="{{ asset('images/power3.png') }}" class="imagepower" ></center>
                                          <br>
                                          <center><img src="{{ asset('images/mdb4.png') }}" class="imagebtn"  id="btn-dpm-4"></center>
                                        </div>
                                  </td>
                                </tr>
                              </table>
                                    {{-- <div class="col-xl-3">
                                        
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="dashed">
                                            <img src="{{ asset('images/power1.png') }}" class="imagepower" >
                                        </div>
                                    </div>
                                    <div class="col-xl-3">
                                        <div class="dashed">
                                            <img src="{{ asset('images/power1.png') }}" class="imagepower" >
                                        </div>
                                    </div> --}}
                             </div>
                            </div>
                    </div>
                </div>
            
          </div>
          <!-- ./box-body -->
          
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
@endsection

@section('scripts')
<script type="text/javascript">

  document.title = "POWER & UTILITY";

  $("#btn-dpm-1").click(function(){
    var mdb = "1";
    var urlRedirect = "{{ route('smartmtcs.dpm', 'param') }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param', mdb);
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  });

  $("#btn-dpm-2").click(function(){
    var mdb = "2";
    var urlRedirect = "{{ route('smartmtcs.dpm', 'param') }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param', mdb);
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  });

  $("#btn-dpm-3").click(function(){
    var mdb = "3";
    var urlRedirect = "{{ route('smartmtcs.dpm', 'param') }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param', mdb);
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  });

  $("#btn-dpm-4").click(function(){
    var mdb = "4";
    var urlRedirect = "{{ route('smartmtcs.dpm', 'param') }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param', mdb);
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  });


  function onBack() {
    var urlRedirect = "{{ route('smartmtcs.dashboardmtc2') }}";
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  }
</script>
@endsection