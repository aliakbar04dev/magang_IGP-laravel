@extends('monitoring.mtc.layouts.app3')
<style type="text/css">
  #field_data { 
   height: 80%; 
    overflow-y: scroll;
    overflow-x: hidden;
    padding-bottom:100px;
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


  @media only screen and (min-width: 600px) {

  .atasdashboard{
    width: 100%; 
    height:100px; 
    padding:0px; 
    margin-left:-50px;
  }

  
  /* .tampilbawah{
    margin-left:-30px;
  } */

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
    text-align: left;
  }

  .hurufbawah{
    font-size: 18px;
    text-transform: uppercase;
    text-align: left;
  }

 .backbutton{
    font-size: 30px;
    text-transform: uppercase;
    float:right;
    height:40px;
    margin-top:-40px;
  }

  .button4{
    width: 120px; 
    height:90px;
    filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));
  }
  
}

@media only screen and (max-width: 599px) {

  .button4{
    width: 80px; 
    height:60px;

    filter: drop-shadow(0 10px 10px rgba(0, 0, 0, 0.8));
  }

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
    text-align: left;
  }

  .hurufbawah{
    font-size: 10px;
    text-transform: uppercase;
    text-align: left;
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
        <div class="box">
          <div class="box-header with-border">
              <div class="row">
                  <div class="col-xl-12" >
                      <img src="{{ asset('images/logosmart.png') }}" class="imagelogo" align="left">
                      <br>
                          <div class="alert alert-danger alert-dismissible" style="height:40px; padding:0px 10px; background-color:#ff7701 !important;">
                                  <p class="huruf">
                                    @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
                                      RESUME PEMAKAIAN OLI IGP-{{ $kd_plant }} BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})
                                    @else 
                                      @if ($kd_site === "IGPK")
                                        RESUME PEMAKAIAN OLI IGP KARAWANG TAHUN {{ $tahun }}
                                      @else 
                                        RESUME PEMAKAIAN OLI IGP JAKARTA TAHUN {{ $tahun }}
                                      @endif
                                    @endif
                                  </p>
                                  
                                  <div class="backbutton" onclick="onBack()">
                                      <button type="button" class="btn bg-navy margin" style="width:70px;"><i class="fa fa-chevron-circle-left"></i></button>
                                    
                                  </div>
                          </div>
                  </div>
              </div>
            {{-- <center>
              <h3 class="box-title" id="box-title" name="box-title" style="font-family:serif;font-size: 30px;">
                <strong>
                  
                </strong>
              </h3>
            </center> --}}
            {{-- <div class="box-tools pull-right">
              <button id="btn-close" name="btn-close" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Close" onclick="window.open('', '_self', ''); window.close();">
                <span class="glyphicon glyphicon-remove"></span>
              </button>
            </div> --}}
          {{-- </div> --}}
          <!-- /.box-header -->
          
        {{-- </div> --}}
        <!-- /.box-body -->
      {{-- </div>
      <!-- /.box -->
    </div> --}}
    <!-- /.col -->
  {{-- </div> --}}
          <!-- /.box-body -->
          <div class="box-body" id="field_data">
            <!-- /.box -->
            @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
              <div class="row" id="field_mesin_bulan_hidrolik">
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">HIDROLIK</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-mesin-bulan-hidrolik" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">LUBRIKASI</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-mesin-bulan-lubrikasi" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">SPINDLE</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-mesin-bulan-spindle" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row" id="field_mesin_hari_hidrolik">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">HIDROLIK</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-mesin-hari-hidrolik" width="1100" height="400"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row" id="field_mesin_hari_lubrikasi">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">LUBRIKASI</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-mesin-hari-lubrikasi" width="1100" height="400"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
              <div class="row" id="field_mesin_hari_spindle">
                <div class="col-md-12">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">SPINDLE</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-mesin-hari-spindle" width="1100" height="400"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            @endif
            
            @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T") 
              <div class="row" id="field_jkt">
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">PLANT IGP JKT - HIDROLIK</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-igpj-hidrolik" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">PLANT IGP JKT - LUBRIKASI</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-igpj-lubrikasi" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">PLANT IGP JKT - SPINDLE</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-igpj-spindle" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            @endif
            @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T") 
              <div class="row" id="field_jkt_hidrolik">
                @if($igp1 === "T") 
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-1 - HIDROLIK</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp1-hidrolik" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($igp2 === "T") 
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-2 - HIDROLIK</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp2-hidrolik" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($igp3 === "T") 
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-3 - HIDROLIK</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp3-hidrolik" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
              </div>
              <!-- /.row -->
            @endif
            @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T") 
              <div class="row" id="field_jkt_lubrikasi">
                @if($igp1 === "T")
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-1 - LUBRIKASI</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp1-lubrikasi" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($igp2 === "T")
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-2 - LUBRIKASI</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp2-lubrikasi" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($igp3 === "T")
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-3 - LUBRIKASI</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp3-lubrikasi" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
              </div>
              <!-- /.row -->
            @endif
            @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T") 
              <div class="row" id="field_jkt_spindle">
                @if($igp1 === "T")
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-1 - SPINDLE</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp1-spindle" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($igp2 === "T")
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-2 - SPINDLE</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp2-spindle" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($igp3 === "T")
                  <div class="col-md-{{ 12/$total_jkt }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT IGP-3 - SPINDLE</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-igp3-spindle" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
              </div>
              <!-- /.row -->
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
            @endif
            @if($kima === "T" || $kimb === "T") 
              <div class="row" id="field_kim">
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">PLANT IGP KIM - HIDROLIK</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-igpk-hidrolik" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">PLANT IGP KIM - LUBRIKASI</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-igpk-lubrikasi" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
                <div class="col-md-4">
                  <div class="box box-primary">
                    <div class="box-header with-border">
                      <h3 class="box-title" id="box-grafik">PLANT IGP KIM - SPINDLE</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse">
                          <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove">
                          <i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <canvas id="canvas-igpk-spindle" width="1100" height="900"></canvas>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  <!-- /.box -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            @endif
            @if($kima === "T" || $kimb === "T") 
              <div class="row" id="field_kim_hidrolik">
                @if($kima === "T") 
                  <div class="col-md-{{ 12/$total_kim }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT KIM-1A - HIDROLIK</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-kima-hidrolik" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($kimb === "T") 
                  <div class="col-md-{{ 12/$total_kim }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT KIM-1B - HIDROLIK</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-kimb-hidrolik" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
              </div>
              <!-- /.row -->
            @endif
            @if($kima === "T" || $kimb === "T")
              <div class="row" id="field_kim_lubrikasi">
                @if($kima === "T")
                  <div class="col-md-{{ 12/$total_kim }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT KIM-1A - LUBRIKASI</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-kima-lubrikasi" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($kimb === "T")
                  <div class="col-md-{{ 12/$total_kim }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT KIM-1B - LUBRIKASI</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-kimb-lubrikasi" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
              </div>
              <!-- /.row -->
            @endif
            @if($kima === "T" || $kimb === "T")
              <div class="row" id="field_kim_spindle">
                @if($kima === "T")
                  <div class="col-md-{{ 12/$total_kim }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT KIM-1A - SPINDLE</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-kima-spindle" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
                @if($kimb === "T")
                  <div class="col-md-{{ 12/$total_kim }}">
                    <div class="box box-primary">
                      <div class="box-header with-border">
                        <h3 class="box-title" id="box-grafik">PLANT KIM-1B - SPINDLE</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse">
                            <i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove">
                            <i class="fa fa-times"></i>
                          </button>
                        </div>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <canvas id="canvas-kimb-spindle" width="1100" height="900"></canvas>
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!-- /.col -->
                @endif
              </div>
              <!-- /.row -->
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
              <div class="box-body">
              </div>
            @endif
          </div>
          <br><br>
          <div class="row" height="200px;">
              
      </div>
          <!-- /.box -->
          <!-- Modal Line -->
          <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="lineModalLabel" aria-hidden="true">
              {{-- <div class="modal-dialog" style="width:800px"> --}}
              <div class="modal-dialog" style="width:80%">
                  <div class="modal-content">
                      <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="lineModalLabel">Popup</h4> <b><font color="red">Klik 2x untuk memilih</font></b>
                      </div>
                      <div class="modal-body">
                          <div class="box-body form-horizontal">
                              <div class="form-group">
                                <div class="col-sm-2">
                                  {!! Form::label('filter_tahun', 'Tahun') !!}
                                  <select id="filter_tahun" name="filter_tahun" aria-controls="filter_status" 
                                  class="form-control select2">
                                    @for ($i = \Carbon\Carbon::now()->format('Y'); $i > \Carbon\Carbon::now()->format('Y')-5; $i--)
                                      @if (isset($tahun))
                                        @if ($i == $tahun)
                                          <option value={{ $i }} selected="selected">{{ $i }}</option>
                                        @else
                                          <option value={{ $i }}>{{ $i }}</option>
                                        @endif
                                      @else 
                                        @if ($i == \Carbon\Carbon::now()->format('Y'))
                                          <option value={{ $i }} selected="selected">{{ $i }}</option>
                                        @else
                                          <option value={{ $i }}>{{ $i }}</option>
                                        @endif
                                      @endif
                                    @endfor
                                  </select>
                                </div>
                                <div class="col-sm-2">
                                  {!! Form::label('filter_bulan', 'Bulan') !!}
                                  <select id="filter_bulan" name="filter_bulan" aria-controls="filter_status" 
                                  class="form-control select2">
                                    @if (isset($bulan))
                                      <option value="01" @if ("01" == $bulan) selected="selected" @endif>Januari</option>
                                      <option value="02" @if ("02" == $bulan) selected="selected" @endif>Februari</option>
                                      <option value="03" @if ("03" == $bulan) selected="selected" @endif>Maret</option>
                                      <option value="04" @if ("04" == $bulan) selected="selected" @endif>April</option>
                                      <option value="05" @if ("05" == $bulan) selected="selected" @endif>Mei</option>
                                      <option value="06" @if ("06" == $bulan) selected="selected" @endif>Juni</option>
                                      <option value="07" @if ("07" == $bulan) selected="selected" @endif>Juli</option>
                                      <option value="08" @if ("08" == $bulan) selected="selected" @endif>Agustus</option>
                                      <option value="09" @if ("09" == $bulan) selected="selected" @endif>September</option>
                                      <option value="10" @if ("10" == $bulan) selected="selected" @endif>Oktober</option>
                                      <option value="11" @if ("11" == $bulan) selected="selected" @endif>November</option>
                                      <option value="12" @if ("12" == $bulan) selected="selected" @endif>Desember</option>
                                    @else 
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
                                    @endif
                                  </select>
                                </div>
                                <div class="col-sm-2">
                                  {!! Form::label('kd_plant', 'Plant') !!}
                                  <select size="1" id="kd_plant" name="kd_plant" class="form-control select2" onchange="changeKdPlant()">
                                    @if (isset($kd_plant))
                                      <option value="ALL">Pilih Plant</option>
                                      @foreach($plant->get() as $kode)
                                        <option value="{{ $kode->kd_plant }}" @if ($kode->kd_plant == $kd_plant) selected="selected" @endif>{{ $kode->nm_plant }}</option>
                                      @endforeach
                                    @else 
                                      <option value="ALL" selected="selected">Pilih Plant</option>
                                      @foreach($plant->get() as $kode)
                                        <option value="{{ $kode->kd_plant }}">{{ $kode->nm_plant }}</option>
                                      @endforeach
                                    @endif
                                  </select>
                                </div>
                                
                              </div>
                              <!-- /.form-group -->
                              <div class="form-group">
                                <div class="col-sm-3">
                                  {!! Form::label('kd_line', 'Line (F9)') !!}
                                    <select id="kd_line" name="kd_line" class="form-control select2" style="width:100%;" onchange="changeline()">
                                        @if (isset($kd_line))
                                          @if($kd_plant == '1')
                                          <option value="ALL">Pilih Plant</option>
                                          <option value="L24" @if ($kd_line == "L24") selected="selected" @endif>L24 = R/A CAT.2</option>
                                          <option value="L25" @if ($kd_line == "L25") selected="selected" @endif>L25 = P/S CAT.2</option>
                                          <option value="L71" @if ($kd_line == "L71") selected="selected" @endif>L71 = HOUSING CAT.2</option>
                                          <option value="L920" @if ($kd_line == "L920") selected="selected" @endif>L920 = TRANSMISI - A</option>
                                          <option value="L922" @if ($kd_line == "L922") selected="selected" @endif>L922 = TRANSMISI - B</option>
                                          <option value="L967" @if ($kd_line == "L967") selected="selected" @endif>L967 = AXLE F</option>
                                          @elseif($kd_plant == '2')
                                          <option value="ALL">Pilih Plant</option>
                                          <option value="L07" @if ($kd_line == "L07") selected="selected" @endif>L07 = AXLE A</option>
                                          <option value="L08" @if ($kd_line == "L08") selected="selected" @endif>L08 = AXLE B</option>
                                          <option value="L83" @if ($kd_line == "L83") selected="selected" @endif>L83 = AXLE D</option>
                                          <option value="L91" @if ($kd_line == "L91") selected="selected" @endif>L91 = AXLE E</option>
                                          <option value="L10" @if ($kd_line == "L10") selected="selected" @endif>L10 = HOUSING A</option>
                                          <option value="L11" @if ($kd_line == "L11") selected="selected" @endif>L11 = HOUSING B</option>
                                          <option value="L71" @if ($kd_line == "L71") selected="selected" @endif>L71 = HOUSING D</option>
                                          <option value="L90" @if ($kd_line == "L90") selected="selected" @endif>L90 = HOUSING E</option>
                                          <option value="L44" @if ($kd_line == "L44") selected="selected" @endif>L44 = SUB ASSY</option>
                                          <option value="L55" @if ($kd_line == "L55") selected="selected" @endif>L55 = B-22</option>
                                          @elseif($kd_plant == '3')
                                          <option value="ALL">Pilih Plant</option>
                                          <option value="L01" @if ($kd_line == "L01") selected="selected" @endif>L01 = R/A - A CAT.1</option>
                                          <option value="L02" @if ($kd_line == "L02") selected="selected" @endif>L02 = D/C - A CAT.1</option>
                                          <option value="L03" @if ($kd_line == "L03") selected="selected" @endif>L03 = R/A - B CAT.1</option>
                                          <option value="L05" @if ($kd_line == "L05") selected="selected" @endif>L05 = P/S 1 - 2 JOINT</option>
                                          <option value="L06" @if ($kd_line == "L06") selected="selected" @endif>L06 = P/S 1 - 3 JOINT</option>
                                          <option value="L15" @if ($kd_line == "L15") selected="selected" @endif>L15 = COMPANION A</option>
                                          <option value="L22" @if ($kd_line == "L22") selected="selected" @endif>L22 = YOKE MITSUBISHI</option>
                                          <option value="L23" @if ($kd_line == "L23") selected="selected" @endif>L23 = YOKE IMV</option>
                                          <option value="L33" @if ($kd_line == "L33") selected="selected" @endif>L33 = P/H TUBE</option>
                                          <option value="L38" @if ($kd_line == "L38") selected="selected" @endif>L38 = YOKE SLEEVE</option>
                                          <option value="L55" @if ($kd_line == "L55") selected="selected" @endif>L55 = YOKE C</option>
                                          <option value="L960" @if ($kd_line == "L960") selected="selected" @endif>L960 = COMPANION B</option>
                                          @endif
                                        @endif
                                    </select>
                                    {{-- @if (isset($kd_line))
                                      {!! Form::text('kd_line', $kd_line, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                                    @else 
                                      {!! Form::text('kd_line', null, ['class'=>'form-control','placeholder' => 'Line', 'maxlength' => 10, 'onkeydown' => 'keyPressedKdLine(event)', 'onchange' => 'validateKdLine()', 'id' => 'kd_line']) !!}
                                    @endif --}}
                                    {{-- <span class="input-group-btn">
                                      <button id="btnpopupline" type="button" class="btn btn-info" data-toggle="modal" data-target="#lineModal">
                                        <span class="glyphicon glyphicon-search"></span>
                                      </button>
                                    </span> --}}
                                </div>
                                <div class="col-sm-4">
                                  {!! Form::label('nm_line', 'Nama Line') !!}
                                  @if (isset($nm_line))
                                    {!! Form::text('nm_line', $nm_line, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
                                  @else 
                                    {!! Form::text('nm_line', null, ['class'=>'form-control','placeholder' => 'Nama Line', 'disabled'=>'', 'id' => 'nm_line']) !!}
                                  @endif
                                </div>
                                <div class="col-sm-2">
                                    <a class="btn btn-app bg-purple" name="btn-resume" id="btn-resume">
                                        <i class="fa fa-home"></i> All Resume
                                      </a>
                                    {{-- {!! Form::label('lblresume', 'Action') !!}
                                    <button id="btn-resume" name="btn-resume" type="button" class="form-control btn btn-primary" data-toggle="tooltip" data-placement="top" title="Total Resume">View Total Resume</button> --}}
                                </div>
                              </div>
                              <!-- /.form-group -->
                            </div>
                            <div class="box" id="box-mesin" name="box-mesin">
                                @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
                                  @include ('mtc.oil.mesin')
                                @endif
                              </div>
                      </div>
                  </div>
              </div>
          </div>
          @include('mtc.lp.popup.lineModal')
        </div>
        <!-- /.field_data -->
      <!-- /.col -->

  

          
  
  <footer style="background-color:white; min-height:150px;" class="navbar-fixed-bottom">
                  <div class="alert alert-danger alert-dismissible" style="height:30px; width:100%; padding:0px 10px; background-color:red !important;">
                          <p class="hurufbawah" >TOP 20 MACHINE USE THE MOST OIL</p>
                  </div>
                  <center>
                      <table id="tblMaster" width="50%" style="margin-bottom:20px;"> 
                          <tr >
                            <td style="width: 20%;text-align: center">
                                <img src="{{ asset('images/oiligp1.png') }}" class="button4"  id="btn-topoli-igp1">
                            </td>
                            <td style="width:5%"></td>
                            <td style="width: 20%;text-align: center">
                              <img src="{{ asset('images/oiligp2.png') }}" class="button4"  id="btn-topoli-igp2">
                            </td>
                            <td style="width:5%"></td>
                            <td style="width: 20%;text-align: center">
                                <img src="{{ asset('images/oiligp3.png') }}" class="button4"  id="btn-topoli-igp3">
                            </td>
                            <td style="width:5%"></td>
                            <td style="width: 20%;text-align: center">
                                <img src="{{ asset('images/oilsearch.png') }}" class="button4"  data-toggle="modal" data-target="#searchModal" id="search">
                            </td>
                          </tr>
                        </table>
                      </center>
             
    {{-- <br>
			<center>
			  <a href="{{ route('smartmtcs.dashboardmtc2') }}" class="btn bg-navy">Home</a>
			</center> --}}
		  </footer>
@endsection

@section('scripts')
<script src="{{ asset('chartjs/Chart.bundle.js') }}"></script>
<script src="{{ asset('chartjs/utils.js') }}"></script>
<script type="text/javascript">
  document.getElementById("filter_tahun").focus();
  //Initialize Select2 Elements
  $(".select2").select2();

  function changeKdPlant() {
    validateKdLine();
  }

  function keyPressedKdLine(e) {
    if(e.keyCode == 120) { //F9
      $('#btnpopupline').click();
    } else if(e.keyCode == 9) { //TAB
      e.preventDefault();
      document.getElementById('btn-resume').focus();
    }
  }

  function popupKdLine() {
    var myHeading = "<p>Popup Line</p>";
    $("#lineModalLabel").html(myHeading);
    var kd_plant = document.getElementById('kd_plant').value.trim();

    
    var url = '{{ route('datatables.popupLines', 'param') }}';
    url = url.replace('param', window.btoa(kd_plant));
    // var lookupLine = $('#lookupLine').DataTable({
    //   processing: true, 
    //   "oLanguage": {
    //     'sProcessing': '<div id="processing" style="margin: 0px; padding: 0px; position: fixed; right: 0px; top: 0px; width: 100%; height: 100%; background-color: rgb(102, 102, 102); z-index: 30001; opacity: 0.8;"><p style="position: absolute; color: White; top: 50%; left: 45%;"><img src="{{ asset('images/ajax-loader.gif') }}"></p></div>Processing...'
    //   }, 
    //   serverSide: true,
    //   "pagingType": "numbers",
    //   ajax: url,
    //   "aLengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
    //   responsive: true,
    //   // "scrollX": true,
    //   // "scrollY": "500px",
    //   // "scrollCollapse": true,
    //   "order": [[1, 'asc']],
    //   columns: [
    //     { data: 'xkd_line', name: 'xkd_line'},
    //     { data: 'xnm_line', name: 'xnm_line'}
    //   ],
    //   "bDestroy": true,
    //   "initComplete": function(settings, json) {
    //     // $('div.dataTables_filter input').focus();
    //     $('#lookupLine tbody').on( 'dblclick', 'tr', function () {
    //       var dataArr = [];
    //       var rows = $(this);
    //       var rowData = lookupLine.rows(rows).data();
    //       $.each($(rowData),function(key,value){
    //         document.getElementById("kd_line").html = value["xkd_line"];
    //         document.getElementById("nm_line").value = value["xnm_line"];
    //         $('#lineModal').modal('hide');
    //         validateKdLine();
    //       });
    //     });
    //     $('#lineModal').on('hidden.bs.modal', function () {
    //       var kd_line = document.getElementById("kd_line").value.trim();
    //       if(kd_line === '') {
    //         document.getElementById("nm_line").value = "";
    //         $("#box-mesin").html("");
    //         $('#kd_line').focus();
    //       } else {
    //         $('#btn-resume').focus();
    //       }
    //     });
    //   },
    // });
  }

  function validateKdLine() {
    var kd_line = $( "#kd_line option:selected" ).val();
    if(kd_line !== '') {
      var kd_plant = document.getElementById('kd_plant').value.trim();
      var kd_plant_modal = $( "#kd_plant option:selected" ).val();
      if(kd_plant_modal == '2'){
        $( "#kd_line" ).html( `
      <option value="L07" selected="selected">L07 = AXLE A</option>
      <option value="L08">L08 = AXLE B</option>
      <option value="L83">L83 = AXLE D</option>
      <option value="L91">L91 = AXLE E</option>
      <option value="L10">L10 = HOUSING A</option>
      <option value="L11">L11 = HOUSING B</option>
      <option value="L71">L71 = HOUSING D</option>
      <option value="L90">L90 = HOUSING E</option>
      <option value="L44">L44 = SUB ASSY</option>
      <option value="L55">L55 = B-22</option>
      ` );
      $("#kd_line").trigger("change");
      }else if(kd_plant_modal == '1'){
        $( "#kd_line" ).html( `
      <option value="L24" selected="selected">L24 = R/A CAT.2</option>
      <option value="L25">L25 = P/S CAT.2</option>
      <option value="L71">L71 = HOUSING CAT.2</option>
      <option value="L920">L920 = TRANSMISI - A</option>
      <option value="L922">L922 = TRANSMISI - B</option>
      <option value="L967">L967 = AXLE F</option>
      ` );
      $("#kd_line").trigger("change");
      }else if(kd_plant_modal == '3'){
        $( "#kd_line" ).html( `
      <option value="L01" selected="selected">L01 = R/A - A CAT.1</option>
      <option value="L02">L02 = D/C - A CAT.1</option>
      <option value="L03">L03 = R/A - B CAT.1</option>
      <option value="L05">L05 = P/S 1 - 2 JOINT</option>
      <option value="L06">L06 = P/S 1 - 3 JOINT</option>
      <option value="L15">L15 = COMPANION A</option>
      <option value="L22">L22 = YOKE MITSUBISHI</option>
      <option value="L23">L23 = YOKE IMV</option>
      <option value="L33">L33 = P/H TUBE</option>
      <option value="L38">L38 = YOKE SLEEVE</option>
      <option value="L55">L55 = YOKE C</option>
      <option value="L960">L960 = COMPANION B</option>
      ` );
      $("#kd_line").trigger("change");
      }
      
    } 
  }

  function changeline(){
    var kd_plant_modal = $( "#kd_plant option:selected" ).val();
    var kd_line = $( "#kd_line option:selected" ).val();
    var url = '{{ route('datatables.validasiLine', ['param','param2']) }}';
      url = url.replace('param2', window.btoa(kd_line));
      url = url.replace('param', window.btoa(kd_plant_modal));
      // use ajax to run the check
      $.get(url, function(result){  
        if(result !== 'null'){
          result = JSON.parse(result);
          // document.getElementById("kd_line").value = result["xkd_line"];
          document.getElementById("nm_line").value = result["xnm_line"];

          var url = "{{ route('mtctolis.daftarmesin', ['param','param2']) }}";
          url = url.replace('param2', window.btoa(kd_line));
          url = url.replace('param', window.btoa(kd_plant_modal));
          $("#box-mesin").load(url);
        } else {
          // document.getElementById("kd_line").value = "";
          document.getElementById("nm_line").value = "";
          $("#box-mesin").html("");
          document.getElementById("btn-resume").focus();
          swal("Line tidak valid!", "Perhatikan inputan anda! tekan F9 untuk tampilkan data.", "error");
        }
      });
  }

  function grafik(kd_mesin) {
    var tahun = $('select[name="filter_tahun"]').val();
    var bulan = $('select[name="filter_bulan"]').val();
    var kd_plant = document.getElementById('kd_plant').value.trim();
    var kd_line = document.getElementById("kd_line").value.trim();
    if(kd_plant !== "ALL" && kd_line !== "") {
      var kd_site = "{{ $kd_site }}";
      var urlRedirect = "{{ route('smartmtcs.resumepengisianoli', ['param','param2','param3','param4','param5','param6']) }}";
      urlRedirect = urlRedirect.replace('param6', kd_mesin);
      urlRedirect = urlRedirect.replace('param5', window.btoa(kd_line));
      urlRedirect = urlRedirect.replace('param4', window.btoa(kd_plant));
      urlRedirect = urlRedirect.replace('param3', window.btoa(bulan));
      urlRedirect = urlRedirect.replace('param2', window.btoa(tahun));
      urlRedirect = urlRedirect.replace('param', kd_site);
      window.location.href = urlRedirect;
    } else {
      if(kd_plant === "ALL" && kd_line === "") {
        document.getElementById("kd_plant").focus();
      } else if(kd_plant === "ALL") {
        document.getElementById("kd_plant").focus();
      } else {
        document.getElementById("kd_line").focus();
      }
      swal("Plant & Line tidak boleh kosong!", "Perhatikan inputan anda!", "warning");
    }
  }

  function onBack() {

window.location.href = "{{ route('smartmtcs.dashboardmtc2') }}";
}

  $(document).ready(function(){

    $("#btn-topoli-igp1").click(function(){
    var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var bulan = "{{ \Carbon\Carbon::now()->format('m') }}";
    var kd_plant = "1";
    var urlRedirect = "{{ route('smartmtcs.toppengisianoli', ['param','param2','param3']) }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param3', kd_plant);
    urlRedirect = urlRedirect.replace('param2', bulan);
    urlRedirect = urlRedirect.replace('param', tahun);
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  });

  $("#btn-topoli-igp2").click(function(){
    var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var bulan = "{{ \Carbon\Carbon::now()->format('m') }}";
    var kd_plant = "2";
    var urlRedirect = "{{ route('smartmtcs.toppengisianoli', ['param','param2','param3']) }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param3', kd_plant);
    urlRedirect = urlRedirect.replace('param2', bulan);
    urlRedirect = urlRedirect.replace('param', tahun);
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  });

  $("#btn-topoli-igp3").click(function(){
    var tahun = "{{ \Carbon\Carbon::now()->format('Y') }}";
    var bulan = "{{ \Carbon\Carbon::now()->format('m') }}";
    var kd_plant = "3";
    var urlRedirect = "{{ route('smartmtcs.toppengisianoli', ['param','param2','param3']) }}?type=smartmtc";
    urlRedirect = urlRedirect.replace('param3', kd_plant);
    urlRedirect = urlRedirect.replace('param2', bulan);
    urlRedirect = urlRedirect.replace('param', tahun);
    // window.location.href = urlRedirect;
    window.location.href = urlRedirect;
  });


    $("#btnpopupline").click(function(){
      popupKdLine();
    });

    $('#btn-resume').click( function () {
      var tahun = $('select[name="filter_tahun"]').val();
      var kd_site = "{{ $kd_site }}";
      var urlRedirect = "{{ route('smartmtcs.resumepengisianoli', ['param','param2']) }}";
      urlRedirect = urlRedirect.replace('param2', window.btoa(tahun));
      urlRedirect = urlRedirect.replace('param', kd_site);
      window.location.href = urlRedirect;
    });
  });

  @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T" || $kima === "T" || $kimb === "T" || (isset($kd_plant) && isset($kd_line) && isset($kd_mesin)))

    @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T")
      var chartDataHJ = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igpj) !!}
          }
        ]
      };

      var chartDataLJ = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igpj) !!}
          }
        ]
      };

      var chartDataSJ = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igpj) !!}
          }
        ]
      };
    @endif

    @if($igp1 === "T")
      var chartDataH1 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igp1) !!}
          }
        ]
      };

      var chartDataL1 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igp1) !!}
          }
        ]
      };

      var chartDataS1 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igp1) !!}
          }
        ]
      };
    @endif

    @if($igp2 === "T")
      var chartDataH2 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igp2) !!}
          }
        ]
      };

      var chartDataL2 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igp2) !!}
          }
        ]
      };

      var chartDataS2 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igp2) !!}
          }
        ]
      };
    @endif

    @if($igp3 === "T")
      var chartDataH3 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igp3) !!}
          }
        ]
      };

      var chartDataL3 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igp3) !!}
          }
        ]
      };

      var chartDataS3 = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igp3) !!}
          }
        ]
      };
    @endif

    @if($kima === "T" || $kimb === "T")
      var chartDataHK = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_igpk) !!}
          }
        ]
      };

      var chartDataLK = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_igpk) !!}
          }
        ]
      };

      var chartDataSK = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_igpk) !!}
          }
        ]
      };
    @endif

    @if($kima === "T")
      var chartDataHA = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_kima) !!}
          }
        ]
      };

      var chartDataLA = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_kima) !!}
          }
        ]
      };

      var chartDataSA = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_kima) !!}
          }
        ]
      };
    @endif

    @if($kimb === "T")
      var chartDataHB = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_h_kimb) !!}
          }
        ]
      };

      var chartDataLB = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_l_kimb) !!}
          }
        ]
      };

      var chartDataSB = {
        labels: {!! json_encode($value_x) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_s_kimb) !!}
          }
        ]
      };
    @endif

    @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
      var chartDataMesinH1 = {
        labels: {!! json_encode($value_bulan) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_bulan_h) !!}
          }
        ]
      };

      var chartDataMesinL1 = {
        labels: {!! json_encode($value_bulan) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_bulan_l) !!}
          }
        ]
      };

      var chartDataMesinS1 = {
        labels: {!! json_encode($value_bulan) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_bulan_s) !!}
          }
        ]
      };

      var chartDataHariH1 = {
        labels: {!! json_encode($value_hari) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_hari_h) !!}
          }
        ]
      };

      var chartDataHariL1 = {
        labels: {!! json_encode($value_hari) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_hari_l) !!}
          }
        ]
      };

      var chartDataHariS1 = {
        labels: {!! json_encode($value_hari) !!}, 
        datasets: 
        [
          {
            type: 'line',
            label: 'Total',
            borderColor: window.chartColors.blue,
            borderWidth: 2,
            fill: false, //[false, 'origin', 'start', 'end']
            data: {!! json_encode($value_y_hari_s) !!}
          }
        ]
      };
    @endif

    window.onload = function() {
      Chart.Legend.prototype.afterFit = function() {
        this.height = this.height + 15;
      };
      
      @if($igp1 === "T" || $igp2 === "T" || $igp3 === "T")
        var ctxHJ = document.getElementById('canvas-igpj-hidrolik').getContext('2d');
        window.myMixedChartHJ = new Chart(ctxHJ, {
          type: 'bar',
          data: chartDataHJ,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP JKT',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxLJ = document.getElementById('canvas-igpj-lubrikasi').getContext('2d');
        window.myMixedChartLJ = new Chart(ctxLJ, {
          type: 'bar',
          data: chartDataLJ,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP JKT',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxSJ = document.getElementById('canvas-igpj-spindle').getContext('2d');
        window.myMixedChartSJ = new Chart(ctxSJ, {
          type: 'bar',
          data: chartDataSJ,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP JKT',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($igp1 === "T")
        var ctxH1 = document.getElementById('canvas-igp1-hidrolik').getContext('2d');
        window.myMixedChartH1 = new Chart(ctxH1, {
          type: 'bar',
          data: chartDataH1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP 1',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxL1 = document.getElementById('canvas-igp1-lubrikasi').getContext('2d');
        window.myMixedChartL1 = new Chart(ctxL1, {
          type: 'bar',
          data: chartDataL1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP 1',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxS1 = document.getElementById('canvas-igp1-spindle').getContext('2d');
        window.myMixedChartS1 = new Chart(ctxS1, {
          type: 'bar',
          data: chartDataS1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP 1',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($igp2 === "T")
        var ctxH2 = document.getElementById('canvas-igp2-hidrolik').getContext('2d');
        window.myMixedChartH2 = new Chart(ctxH2, {
          type: 'bar',
          data: chartDataH2,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP 2',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxL2 = document.getElementById('canvas-igp2-lubrikasi').getContext('2d');
        window.myMixedChartL2 = new Chart(ctxL2, {
          type: 'bar',
          data: chartDataL2,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP 2',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxS2 = document.getElementById('canvas-igp2-spindle').getContext('2d');
        window.myMixedChartS2 = new Chart(ctxS2, {
          type: 'bar',
          data: chartDataS2,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP 2',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($igp3 === "T")
        var ctxH3 = document.getElementById('canvas-igp3-hidrolik').getContext('2d');
        window.myMixedChartH3 = new Chart(ctxH3, {
          type: 'bar',
          data: chartDataH3,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP 3',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxL3 = document.getElementById('canvas-igp3-lubrikasi').getContext('2d');
        window.myMixedChartL3 = new Chart(ctxL3, {
          type: 'bar',
          data: chartDataL3,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP 3',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxS3 = document.getElementById('canvas-igp3-spindle').getContext('2d');
        window.myMixedChartS3 = new Chart(ctxS3, {
          type: 'bar',
          data: chartDataS3,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP 3',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($kima === "T" || $kimb === "T")
        var ctxHK = document.getElementById('canvas-igpk-hidrolik').getContext('2d');
        window.myMixedChartHK = new Chart(ctxHK, {
          type: 'bar',
          data: chartDataHK,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - IGP KIM',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxLK = document.getElementById('canvas-igpk-lubrikasi').getContext('2d');
        window.myMixedChartLK = new Chart(ctxLK, {
          type: 'bar',
          data: chartDataLK,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - IGP KIM',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxSK = document.getElementById('canvas-igpk-spindle').getContext('2d');
        window.myMixedChartSK = new Chart(ctxSK, {
          type: 'bar',
          data: chartDataSK,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - IGP KIM',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($kima === "T")
        var ctxHA = document.getElementById('canvas-kima-hidrolik').getContext('2d');
        window.myMixedChartHA = new Chart(ctxHA, {
          type: 'bar',
          data: chartDataHA,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - KIM 1A',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxLA = document.getElementById('canvas-kima-lubrikasi').getContext('2d');
        window.myMixedChartLA = new Chart(ctxLA, {
          type: 'bar',
          data: chartDataLA,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - KIM 1A',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxSA = document.getElementById('canvas-kima-spindle').getContext('2d');
        window.myMixedChartSA = new Chart(ctxSA, {
          type: 'bar',
          data: chartDataSA,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - KIM 1A',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
      @if($kimb === "T")
        var ctxHB = document.getElementById('canvas-kimb-hidrolik').getContext('2d');
        window.myMixedChartHB = new Chart(ctxHB, {
          type: 'bar',
          data: chartDataHB,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK {{ $tahun }} - KIM 1B',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxLB = document.getElementById('canvas-kimb-lubrikasi').getContext('2d');
        window.myMixedChartLB = new Chart(ctxLB, {
          type: 'bar',
          data: chartDataLB,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI {{ $tahun }} - KIM 1B',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxSB = document.getElementById('canvas-kimb-spindle').getContext('2d');
        window.myMixedChartSB = new Chart(ctxSB, {
          type: 'bar',
          data: chartDataSB,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE {{ $tahun }} - KIM 1B',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif

      @if (isset($kd_plant) && isset($kd_line) && isset($kd_mesin))
        var ctxMesinH1 = document.getElementById('canvas-mesin-bulan-hidrolik').getContext('2d');
        window.myMixedChartMesinH1 = new Chart(ctxMesinH1, {
          type: 'bar',
          data: chartDataMesinH1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK - TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxMesinL1 = document.getElementById('canvas-mesin-bulan-lubrikasi').getContext('2d');
        window.myMixedChartMesinL1 = new Chart(ctxMesinL1, {
          type: 'bar',
          data: chartDataMesinL1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI - TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxMesinS1 = document.getElementById('canvas-mesin-bulan-spindle').getContext('2d');
        window.myMixedChartMesinS1 = new Chart(ctxMesinS1, {
          type: 'bar',
          data: chartDataMesinS1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE - TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxHariH1 = document.getElementById('canvas-mesin-hari-hidrolik').getContext('2d');
        window.myMixedChartHariH1 = new Chart(ctxHariH1, {
          type: 'bar',
          data: chartDataHariH1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI HIDROLIK - BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxHariL1 = document.getElementById('canvas-mesin-hari-lubrikasi').getContext('2d');
        window.myMixedChartHariL1 = new Chart(ctxHariL1, {
          type: 'bar',
          data: chartDataHariL1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI LUBRIKASI - BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });

        var ctxHariS1 = document.getElementById('canvas-mesin-hari-spindle').getContext('2d');
        window.myMixedChartHariS1 = new Chart(ctxHariS1, {
          type: 'bar',
          data: chartDataHariS1,
          options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true,
                  // max: 100, 
                  // stepSize: 10, 
                  callback: function(value, index, values) {
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    value = intVal(value);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    return format(value) + ' L';
                  }
                },
                gridLines: {
                  display:true
                }
              }],
              xAxes: [{
                ticks: {
                  callback: function(t) {
                    var maxLabelLength = 20;
                    if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                    else return t;
                  }, 
                  autoSkip: false,
                  maxRotation: 30,
                  // minRotation: 30
                },
                gridLines: {
                  display:true
                }   
              }]
            },
            "hover": {
              "animationDuration": 0
            },
            "animation": {
              // "duration": 1,
              "onComplete": function() {
                var chartInstance = this.chart,
                ctx = chartInstance.ctx;

                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
                ctx.fillStyle = 'black';
                ctx.textAlign = 'center';
                ctx.textBaseline = 'bottom';

                this.data.datasets.forEach(function(dataset, i) {
                  var meta = chartInstance.controller.getDatasetMeta(i);
                  meta.data.forEach(function(bar, index) {
                    var data = dataset.data[index];
                    // Remove the formatting to get integer data for summation
                    var intVal = function (i) {
                      return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                      i : 0;
                    };
                    data = intVal(data);

                    var format = function formatNumber(num) {
                      return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
                    };

                    data = format(data);
                    ctx.fillText(data, bar._model.x, bar._model.y - 5);
                  });
                });
              }
            },
            title: {
              display: true,
              position: 'top', 
              text: 'PEMAKAIAN OLI SPINDLE - BULAN {{ strtoupper(namaBulan((int) $bulan)) }} TAHUN {{ $tahun }} (M/C {{ $kd_mesin }})',
              fontSize: 14,
            },
            legend: {
              position: 'top', 
              "display": true,
              labels: {
                // This more specific font property overrides the global property
                fontColor: 'black',
                //fontSize: 12,
              }
            },
            tooltips: {
              callbacks: {
                title: function(t, d) {
                  return d.labels[t[0].index];
                }
              }, 
              mode: 'index',
              intersect: true, 
              callbacks: {
                title: function(tooltipItem, data) {
                  return data['labels'][tooltipItem[0].index];
                },
                label: function(tooltipItem, data) {
                  return data.datasets[tooltipItem.datasetIndex].label + ": " + tooltipItem.yLabel + " L";
                },
              },
            }
          }
        });
      @endif
    };
  @endif
</script>
@endsection